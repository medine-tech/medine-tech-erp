<?php

declare(strict_types=1);

namespace App\Http\Controllers\Backoffice\Accounting\AccountingCenters;

use App\Http\Controllers\ApiController;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use MedineTech\Backoffice\Accounting\AccountingCenter\Application\Update\AccountingCenterUpdater;
use MedineTech\Backoffice\Accounting\AccountingCenter\Application\Update\AccountingCenterUpdaterRequest;
use MedineTech\Backoffice\Accounting\AccountingCenter\Domain\AccountingCenterNotFound;
use Spatie\Permission\Exceptions\UnauthorizedException;
use Symfony\Component\HttpFoundation\Response;

/**
 * @OA\Put(
 *     path="/api/backoffice/{tenant}/accounting/accounting-centers/{id}",
 *     tags={"Backoffice - Accounting - Accounting Centers"},
 *     summary="Update an existing accounting center",
 *     security={ {"bearerAuth": {} } },
 *     @OA\Parameter(
 *         name="tenant",
 *         in="path",
 *         required=true,
 *         description="The tenant ID",
 *         @OA\Schema(type="string")
 *     ),
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="The ID of the accounting center to update",
 *         @OA\Schema(type="string", format="uuid")
 *     ),
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"name", "status"},
 *             @OA\Property(property="name", type="string", example="Updated Center Name"),
 *             @OA\Property(property="description", type="string", example="Updated accounting center description", nullable=true),
 *             @OA\Property(property="status", type="string", example="INACTIVE", description="Center status"),
 *             @OA\Property(property="parent_id", type="string", example="123e4567-e89b-12d3-a456-426655440000", nullable=true, description="Parent center ID")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Accounting center updated successfully"
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Validation error",
 *         @OA\JsonContent(
 *             @OA\Property(property="title", type="string", example="Validation Error"),
 *             @OA\Property(property="status", type="integer", example=400),
 *             @OA\Property(property="detail", type="string", example="The given data was invalid."),
 *             @OA\Property(property="errors", type="object")
 *         )
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Accounting center not found",
 *         @OA\JsonContent(
 *             @OA\Property(property="title", type="string", example="Not Found"),
 *             @OA\Property(property="status", type="integer", example=404),
 *             @OA\Property(property="detail", type="string", example="Accounting center not found with the provided ID.")
 *         )
 *      ),
 *     @OA\Response(
 *         response=403,
 *         description="Unauthorized",
 *         @OA\JsonContent(
 *             @OA\Property(property="title", type="string", example="Unauthorized"),
 *             @OA\Property(property="status", type="integer", example=403),
 *             @OA\Property(property="detail", type="string", example="You do not have permission to update this resource.")
 *         )
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Internal server error",
 *         @OA\JsonContent(
 *             @OA\Property(property="title", type="string", example="Error"),
 *             @OA\Property(property="status", type="integer", example=500),
 *             @OA\Property(property="detail", type="string", example="An unexpected error occurred while processing your request.")
 *         )
 *     )
 * )
 */
final class AccountingCenterPutController extends ApiController
{
    public function __construct(
        private readonly AccountingCenterUpdater $updater,
    ) {
    }

    public function __invoke(string $id, Request $request): JsonResponse
    {
        return $this->execute(function () use ($id, $request) {
            // Permissions check is commented out in original code
            // if (!$request->user()->can(AccountingCenterPermissions::UPDATE)) {
            //     throw new UnauthorizedException(403);
            // }

            $validatedData = $request->validate([
                'name' => 'required|string',
                'description' => 'nullable|string',
                'status' => 'required|string',
                'parent_id' => 'nullable|string',
            ]);

            $userId = $request->user()->id;

            $updaterRequest = new AccountingCenterUpdaterRequest(
                $id,
                $validatedData['name'],
                $validatedData['description'] ?? null,
                $validatedData['status'],
                $userId,
                $validatedData['parent_id'] ?? null
            );

            DB::transaction(function () use ($updaterRequest) {
                ($this->updater)($updaterRequest);
            });

            return new JsonResponse(null, Response::HTTP_OK);
        });
    }

    protected function exceptions(): array
    {
        return [
            ValidationException::class => Response::HTTP_BAD_REQUEST,
            AccountingCenterNotFound::class => Response::HTTP_NOT_FOUND,
            UnauthorizedException::class => Response::HTTP_FORBIDDEN,
        ];
    }

    protected function exceptionDetail(\Exception $error): string
    {
        if ($error instanceof ValidationException) {
            return 'The given data was invalid.';
        }

        if ($error instanceof AccountingCenterNotFound) {
            return 'Accounting center not found with the provided ID.';
        }

        if ($error instanceof UnauthorizedException) {
            return 'You do not have permission to update this resource.';
        }

        return parent::exceptionDetail($error);
    }
}
