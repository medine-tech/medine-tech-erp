<?php

declare(strict_types=1);

namespace App\Http\Controllers\Backoffice\Accounting\AccountingAccounts;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use MedineTech\Backoffice\Accounting\AccountingAccounts\Application\Update\AccountingAccountUpdater;
use MedineTech\Backoffice\Accounting\AccountingAccounts\Application\Update\AccountingAccountUpdaterRequest;
use MedineTech\Backoffice\Accounting\AccountingAccounts\Domain\AccountingAccountNotFound;
use MedineTech\Backoffice\Accounting\AccountingAccounts\Infrastructure\Authorization\AccountingAccountsPermissions;
use Spatie\Permission\Exceptions\UnauthorizedException;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * @OA\Put(
 *     path="/api/backoffice/{tenant}/accounting/accounting-accounts/{id}",
 *     tags={"Backoffice - Accounting - Accounting Accounts"},
 *     summary="Update an existing accounting account",
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
 *         description="The ID of the accounting account to update",
 *         @OA\Schema(type="string", format="uuid")
 *     ),
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"name", "type", "status"},
 *             @OA\Property(property="name", type="string", example="Updated Account Name"),
 *             @OA\Property(property="description", type="string", example="Updated account description", nullable=true),
 *             @OA\Property(property="type", type="integer", example=1, description="1 = asset, 2 = liability, 3 = equity, 4 = revenue, 5 = expense"),
 *             @OA\Property(property="status", type="string", example="INACTIVE", description="Account status"),
 *             @OA\Property(property="parent_id", type="string", example="123e4567-e89b-12d3-a456-426655440000", nullable=true, description="Parent account ID")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Accounting account updated successfully"
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
 *         description="Accounting account not found",
 *         @OA\JsonContent(
 *             @OA\Property(property="title", type="string", example="Not Found"),
 *             @OA\Property(property="status", type="integer", example=404),
 *             @OA\Property(property="detail", type="string", example="Accounting account not found with the provided ID.")
 *         )
 *      ),
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
 *             @OA\Property(property="title", type="string", example="Error"),
 *             @OA\Property(property="status", type="integer", example=500),
 *             @OA\Property(property="detail", type="string", example="An unexpected error occurred while processing your request.")
 *         )
 *     )
 * )
 */
final class AccountingAccountPutController
{
    public function __construct(
        private AccountingAccountUpdater $updater,
    ) {
    }

    public function __invoke(string $id, Request $request): JsonResponse
    {
        try {
            if (!$request->user()->can(AccountingAccountsPermissions::UPDATE)) {
                throw new UnauthorizedException(403);
            }

            $validatedData = $request->validate([
                'name' => 'required|string',
                'description' => 'nullable|string',
                'type' => 'required|int',
                'status' => 'required|string',
                'parent_id' => 'nullable|string',
            ]);

            $userId = $request->user()->id;

            $updaterRequest = new AccountingAccountUpdaterRequest(
                $id,
                $validatedData['name'],
                $validatedData['description'],
                $validatedData['type'],
                $validatedData['status'],
                $userId,
                $validatedData['parent_id'],
            );

            ($this->updater)($updaterRequest);

            return new JsonResponse(null, JsonResponse::HTTP_OK);
        } catch (ValidationException $e) {
            return new JsonResponse([
                'title' => 'Validation Error',
                'status' => JsonResponse::HTTP_BAD_REQUEST,
                'errors' => $e->errors(),
            ], JsonResponse::HTTP_BAD_REQUEST);
        } catch (AccountingAccountNotFound $e) {
            return new JsonResponse([
                'title' => 'Not Found',
                'status' => JsonResponse::HTTP_NOT_FOUND,
                'detail' => 'Accounting account not found with the provided ID.',
            ], JsonResponse::HTTP_NOT_FOUND);
        } catch (UnauthorizedException $e) {
            return new JsonResponse([
                'title' => 'Unauthorized',
                'status' => JsonResponse::HTTP_FORBIDDEN,
                'detail' => 'You do not have permission to view this resource.',
            ], JsonResponse::HTTP_FORBIDDEN);
        } catch (Exception $e) {
            return new JsonResponse([
                'title' => 'Error',
                'status' => JsonResponse::HTTP_INTERNAL_SERVER_ERROR,
                'detail' => 'An unexpected error occurred while processing your request.',
                'message' => $e->getMessage(),
            ], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
