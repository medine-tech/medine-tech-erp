<?php
declare(strict_types=1);

namespace App\Http\Controllers\Backoffice\Companies;

use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use MedineTech\Backoffice\Companies\Application\Find\CompanyFinder;
use MedineTech\Backoffice\Companies\Application\Find\CompanyFinderRequest;
use MedineTech\Backoffice\Companies\Domain\CompanyNotFound;
use MedineTech\Backoffice\Companies\Infrastructure\Authorization\CompaniesPermissions;
use Spatie\Permission\Exceptions\UnauthorizedException;
use Symfony\Component\HttpFoundation\Response;

/**
 * @OA\Get(
 *     path="/api/backoffice/{tenant}/companies/{id}",
 *     tags={"Backoffice - Companies"},
 *     summary="Get a company by ID",
 *     description="Returns the details of a company based on the provided ID.",
 *     security={
 *         {"bearerAuth": {}}
 *     },
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="The ID of the company to retrieve",
 *         @OA\Schema(
 *             type="string",
 *             format="uuid",
 *             example="123e4567-e89b-12d3-a456-426655440000"
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Company details retrieved successfully",
 *         @OA\JsonContent(
 *             @OA\Property(property="id", type="string", example="123e4567-e89b-12d3-a456-426655440000"),
 *             @OA\Property(property="name", type="string", example="MedineTech")
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
 *         response=404,
 *         description="Company not found",
 *         @OA\JsonContent(
 *             @OA\Property(property="title", type="string", example="Company not found"),
 *             @OA\Property(property="status", type="integer", example=404),
 *             @OA\Property(property="detail", type="string", example="The company with id <123e4567-e89b-12d3-a456-426655440000> does not exist.")
 *         )
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Internal Server Error",
 *         @OA\JsonContent(
 *             @OA\Property(property="title", type="string", example="Internal Server Error"),
 *             @OA\Property(property="status", type="integer", example=500),
 *             @OA\Property(property="detail", type="string", example="An unexpected error occurred.")
 *         )
 *     )
 * )
 */
final class CompanyGetController extends ApiController
{
    public function __construct(
        private readonly CompanyFinder $finder
    ) {
    }

    public function __invoke(string $id, Request $request): JsonResponse
    {
        return $this->execute(function () use ($id, $request) {
            if (!$request->user()->can(CompaniesPermissions::VIEW)) {
                throw new UnauthorizedException(403);
            }

            $response = ($this->finder)(
                new CompanyFinderRequest((string)$id)
            );

            return new JsonResponse([
                'id' => $response->id(),
                'name' => $response->name()
            ], Response::HTTP_OK);
        });
    }

    protected function exceptions(): array
    {
        return [
            CompanyNotFound::class => Response::HTTP_NOT_FOUND,
            UnauthorizedException::class => Response::HTTP_FORBIDDEN,
        ];
    }
}
