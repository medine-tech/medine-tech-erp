<?php

declare(strict_types=1);

namespace App\Http\Controllers\Backoffice\Accounting\AccountingCenters;

use App\Http\Controllers\ApiController;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use MedineTech\Backoffice\Accounting\AccountingCenter\Application\Find\AccountingCenterFinder;
use MedineTech\Backoffice\Accounting\AccountingCenter\Application\Find\AccountingCenterFinderRequest;
use MedineTech\Backoffice\Accounting\AccountingCenter\Domain\AccountingCenterNotFound;
use MedineTech\Backoffice\Accounting\AccountingCenter\Infrastructure\Authorization\AccountingCenterPermissions;
use Spatie\Permission\Exceptions\UnauthorizedException;
use Symfony\Component\HttpFoundation\Response;

/**
 * @OA\Get(
 *     path="/api/backoffice/{tenant}/accounting/accounting-centers/{id}",
 *     tags={"Backoffice - Accounting - Accounting Centers"},
 *     summary="Retrieve an accounting center by ID",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         description="Accounting Center ID",
 *         required=true,
 *         @OA\Schema(type="string")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Accounting Center found successfully",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="id", type="string", example="1"),
 *             @OA\Property(property="code", type="string", example="ACC-01"),
 *             @OA\Property(property="name", type="string", example="Main Accounting Center"),
 *             @OA\Property(property="description", type="string", example="Description of the Accounting Center"),
 *             @OA\Property(property="status", type="string", example="ACTIVE"),
 *             @OA\Property(property="parentId", type="string", nullable=true, example="NULL"),
 *             @OA\Property(property="creatorId", type="integer", example=1),
 *             @OA\Property(property="updaterId", type="integer", example=1),
 *             @OA\Property(property="companyId", type="string", example="COMPANY-UUID")
 *         )
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Accounting Center Not Found",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="title", type="string", example="Accounting Center Not Found"),
 *             @OA\Property(property="status", type="integer", example=404),
 *             @OA\Property(property="detail", type="string", example="Accounting Center with the given ID does not exist")
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
 *         description="Internal server error",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="title", type="string", example="Internal Server Error"),
 *             @OA\Property(property="status", type="integer", example=500),
 *             @OA\Property(property="detail", type="string", example="An Unexpected Error Occurred")
 *         )
 *     ),
 *     security={
 *         {"bearerAuth":{}}
 *     }
 * )
 */
final class AccountingCenterGetController extends ApiController
{
    public function __construct(
        private readonly AccountingCenterFinder $finder
    ) {
    }

    public function __invoke(string $id, Request $request): JsonResponse
    {
        return $this->execute(function () use ($id, $request) {
//             Permissions check is commented out in original code
             if (!$request->user()->can(AccountingCenterPermissions::VIEW)) {
                 throw new UnauthorizedException(403);
             }

            $response = ($this->finder)(
                new AccountingCenterFinderRequest($id));

            return new JsonResponse([
                'id' => $response->id(),
                'code' => $response->code(),
                'name' => $response->name(),
                'description' => $response->description(),
                'status' => $response->status(),
                'parentId' => $response->parentId(),
                'creatorId' => $response->creatorId(),
                'updaterId' => $response->updaterId(),
                'companyId' => $response->companyId(),
            ], Response::HTTP_OK);
        });
    }

    protected function exceptions(): array
    {
        return [
            AccountingCenterNotFound::class => Response::HTTP_NOT_FOUND,
            UnauthorizedException::class => Response::HTTP_FORBIDDEN,
        ];
    }

    protected function exceptionDetail(\Exception $error): string
    {
        if ($error instanceof AccountingCenterNotFound) {
            return 'Accounting Center with the given ID does not exist';
        }

        if ($error instanceof UnauthorizedException) {
            return 'You do not have permission to view this resource.';
        }

        return parent::exceptionDetail($error);
    }
}
