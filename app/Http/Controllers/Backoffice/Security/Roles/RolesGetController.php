<?php

declare(strict_types=1);

namespace App\Http\Controllers\Backoffice\Security\Roles;

use App\Http\Controllers\ApiController;
use Exception;
use Illuminate\Http\Request;
use MedineTech\Backoffice\Security\Roles\Application\Search\RolesSearcher;
use MedineTech\Backoffice\Security\Roles\Application\Search\RolesSearcherRequest;
use MedineTech\Backoffice\Security\Roles\Infrastructure\Authorization\RolesPermissions;
use Spatie\Permission\Exceptions\UnauthorizedException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

/**
 * @OA\Get(
 *     path="/api/backoffice/{tenant}/security/roles",
 *     summary="Search roles based on filters",
 *     tags={"Backoffice - Security - Roles"},
 *     security={
 *         {"bearerAuth": {}}
 *     },
 *     @OA\Parameter(
 *         name="tenant",
 *         in="path",
 *         required=true,
 *         description="The tenant ID",
 *         @OA\Schema(type="string")
 *     ),
 *     @OA\Parameter(
 *         name="page",
 *         in="query",
 *         description="Page number for pagination",
 *         required=false,
 *         @OA\Schema(
 *             type="integer",
 *             minimum=1
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Successful retrieval of roles list",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="items", type="array",
 *                 @OA\Items(
 *                     type="object",
 *                     @OA\Property(property="id", type="integer", example=1),
 *                     @OA\Property(property="code", type="string", example="ROL23000001"),
 *                     @OA\Property(property="name", type="string", example="Admin"),
 *                     @OA\Property(property="description", type="string", example="Administrator role", nullable=true),
 *                     @OA\Property(property="status", type="string", example="ACTIVE", description="Role status"),
 *                     @OA\Property(property="creatorId", type="integer", example=1),
 *                     @OA\Property(property="updaterId", type="integer", example=1),
 *                     @OA\Property(property="companyId", type="string", example="company-123")
 *                 )
 *             ),
 *             @OA\Property(property="total", type="integer", example=100),
 *             @OA\Property(property="per_page", type="integer", example=10),
 *             @OA\Property(property="current_page", type="integer", example=1)
 *         )
 *     ),
 *     @OA\Response(
 *         response=403,
 *         description="Unauthorized",
 *         @OA\JsonContent(
 *             @OA\Property(property="title", type="string", example="Unauthorized"),
 *             @OA\Property(property="status", type="integer", example=403),
 *             @OA\Property(property="detail", type="string", example="You do not have permission to view this resource.")
 *         )
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Internal Server Error",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="title", type="string", example="Internal Server Error"),
 *             @OA\Property(property="detail", type="string", example="An unexpected error occurred"),
 *             @OA\Property(property="status", type="integer", example=500)
 *         )
 *     )
 * )
 */
final class RolesGetController extends ApiController
{
    public function __construct(
        private readonly RolesSearcher $searcher
    ) {
    }

    public function __invoke(Request $request): \Illuminate\Http\JsonResponse
    {
        if (!$request->user()->can(RolesPermissions::UPDATE)) {
            throw new UnauthorizedException(403);
        }

        return $this->execute(function () use ($request) {
            $filters = (array)$request->query();
            $filters["company_id"] = $request->user()->id;

            $searcherRequest = new RolesSearcherRequest($filters);
            $searcherResponse = ($this->searcher)($searcherRequest);

            $roles = array_map(function ($role) {
                return [
                    "id" => $role->id(),
                    "code" => $role->code(),
                    "name" => $role->name(),
                    "description" => $role->description(),
                    "status" => $role->status(),
                    "creatorId" => $role->creatorId(),
                    "updaterId" => $role->updaterId(),
                    "companyId" => $role->companyId(),
                ];
            }, $searcherResponse->items());

            return new JsonResponse([
                "items" => $roles,
                "total" => $searcherResponse->total(),
                "per_page" => $searcherResponse->perPage(),
                "current_page" => $searcherResponse->currentPage()
            ], Response::HTTP_OK);
        });
    }

    protected function exceptions(): array
    {
        return [
            UnauthorizedException::class => Response::HTTP_FORBIDDEN
        ];
    }

    protected function exceptionDetail(Exception $error): string
    {
        if ($error instanceof UnauthorizedException) {
            return 'You do not have permission to view this resource.';
        }

        return parent::exceptionDetail($error);
    }
}
