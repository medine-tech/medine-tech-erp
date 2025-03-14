<?php
declare(strict_types=1);

namespace App\Http\Controllers\Backoffice\Accounting\AccountingAccounts;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use MedineTech\Backoffice\Accounting\AccountingAccounts\Application\Update\AccountingAccountUpdater;
use MedineTech\Backoffice\Accounting\AccountingAccounts\Application\Update\AccountingAccountUpdaterRequest;
use MedineTech\Backoffice\Accounting\AccountingAccounts\Domain\AccountingAccountNotFound;
use MedineTech\Backoffice\Accounting\AccountingAccounts\Infrastructure\Authorization\AccountingAccountsPermissions;
use Spatie\Permission\Exceptions\UnauthorizedException;
use Symfony\Component\HttpFoundation\JsonResponse;

final class AccountingAccountPutController
{
    public function __construct(
        private AccountingAccountUpdater $updater,
    )
    {
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

            DB::transaction(function () use ($updaterRequest) {
                ($this->updater)($updaterRequest);
            });

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
                'detail' => 'An unexpected error occurred while processing your request.'
            ], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
