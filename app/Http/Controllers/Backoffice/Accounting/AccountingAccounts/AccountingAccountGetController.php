<?php

declare(strict_types=1);

namespace App\Http\Controllers\Backoffice\Accounting\AccountingAccounts;

use Exception;
use Illuminate\Http\Request;
use MedineTech\Backoffice\Accounting\AccountingAccounts\Application\Find\AccountingAccountFinder;
use MedineTech\Backoffice\Accounting\AccountingAccounts\Application\Find\AccountingAccountFinderRequest;
use MedineTech\Backoffice\Accounting\AccountingAccounts\Domain\AccountingAccountNotFound;
use MedineTech\Backoffice\Accounting\AccountingAccounts\Infrastructure\Authorization\AccountingAccountsPermissions;
use Spatie\Permission\Exceptions\UnauthorizedException;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * @OA\Get(
 *     path="/api/backoffice/{tenant}/accounting/accounting-accounts/{id}",
 *     tags={"Backoffice - Accounting - Accounting Accounts"},
 *     summary="Get an accounting account by ID",
 *     description="Returns the details of an accounting account based on the provided ID.",
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
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="The ID of the accounting account to retrieve",
 *         @OA\Schema(
 *             type="string",
 *             format="uuid",
 *             example="123e4567-e89b-12d3-a456-426655440000"
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Accounting account details retrieved successfully",
 *         @OA\JsonContent(
 *             @OA\Property(property="id", type="string", example="123e4567-e89b-12d3-a456-426655440000"),
 *             @OA\Property(property="code", type="string", example="101"),
 *             @OA\Property(property="name", type="string", example="Cash Account"),
 *             @OA\Property(property="description", type="string", example="Main cash account", nullable=true),
 *             @OA\Property(property="type", type="integer", example=1, description="1 = asset, 2 = liability, 3 = equity, 4 = revenue, 5 = expense"),
 *             @OA\Property(property="status", type="string", example="ACTIVE", description="Account status"),
 *             @OA\Property(property="parent_id", type="string", example="123e4567-e89b-12d3-a456-426655440001", nullable=true),
 *             @OA\Property(property="creator_id", type="integer", example=1),
 *             @OA\Property(property="updater_id", type="integer", example=1),
 *             @OA\Property(property="company_id", type="string", example="company-123")
 *         )
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Accounting account not found",
 *         @OA\JsonContent(
 *             @OA\Property(property="title", type="string", example="Accounting account not found"),
 *             @OA\Property(property="status", type="integer", example=404),
 *             @OA\Property(property="detail", type="string", example="The accounting account with id <123e4567-e89b-12d3-a456-426655440000> does not exist.")
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
 *             @OA\Property(property="title", type="string", example="Internal Server Error"),
 *             @OA\Property(property="status", type="integer", example=500),
 *             @OA\Property(property="detail", type="string", example="An unexpected error occurred.")
 *         )
 *     )
 * )
 */
final class AccountingAccountGetController
{
    public function __construct(
        private AccountingAccountFinder $finder,
    )
    {
    }

    public function __invoke(string $id, Request $request): JsonResponse
    {
        try {
            if (!$request->user()->can(AccountingAccountsPermissions::VIEW)) {
                throw new UnauthorizedException(403);
            }

            $response = ($this->finder)(
                new AccountingAccountFinderRequest((string)$id)
            );

            return new JsonResponse([
                'id' => $response->id(),
                'code' => $response->code(),
                'name' => $response->name(),
                'description' => $response->description(),
                'type' => $response->type(),
                'status' => $response->status(),
                'parent_id' => $response->parentId(),
                'creator_id' => $response->creatorId(),
                'updater_id' => $response->updaterId(),
                'company_id' => $response->companyId()
            ], JsonResponse::HTTP_OK);

        } catch (AccountingAccountNotFound $e) {
            return new JsonResponse([
                'title' => 'Accounting account not found',
                'status' => JsonResponse::HTTP_NOT_FOUND,
                'detail' => "The accounting account with id <$id> does not exist."
            ], JsonResponse::HTTP_NOT_FOUND);
        } catch (UnauthorizedException $e) {
            return new JsonResponse([
                'title' => 'Unauthorized',
                'status' => JsonResponse::HTTP_FORBIDDEN,
                'detail' => 'You are not authorized to view this accounting account.'
            ], JsonResponse::HTTP_FORBIDDEN);
        } catch (Exception $e) {
            return new JsonResponse([
                'title' => 'Internal Server Error',
                'status' => JsonResponse::HTTP_INTERNAL_SERVER_ERROR,
                'detail' => 'An error occurred while processing your request.',
                'message' => $e->getMessage()
            ], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
