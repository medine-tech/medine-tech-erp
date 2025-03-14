<?php
declare(strict_types=1);

namespace App\Http\Controllers\Backoffice\Accounting\AccountingAccounts;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use MedineTech\Backoffice\Accounting\AccountingAccounts\Application\Create\AccountingAccountCreator;
use MedineTech\Backoffice\Accounting\AccountingAccounts\Application\Create\AccountingAccountCreatorRequest;
use MedineTech\Backoffice\Accounting\AccountingAccounts\Infrastructure\Authorization\AccountingAccountsPermissions;
use Spatie\Permission\Exceptions\UnauthorizedException;
use Symfony\Component\HttpFoundation\JsonResponse;

final class AccountingAccountPostController
{
    public function __construct(private readonly AccountingAccountCreator $creator)
    {
    }

    public function __invoke(Request $request): JsonResponse
    {
        try {
            if (!$request->user()->can(AccountingAccountsPermissions::CREATE)) {
                throw new UnauthorizedException(403);
            }

            $validatedData = $request->validate([
                'id' => 'required|string|uuid',
                'code' => 'required|string|min:3|max:40',
                'name' => 'required|string|min:3|max:40',
                'description' => 'nullable|string|min:3|max:100',
                'type' => 'required|int',
                'parent_id' => 'nullable|string|uuid',
            ]);

            $userId = $request->user()->id;

            $creatorRequest = new AccountingAccountCreatorRequest(
                $validatedData['id'],
                $validatedData['code'],
                $validatedData['name'],
                $validatedData['description'] ?? null,
                $validatedData['type'],
                $validatedData['parent_id'] ?? null,
                $userId,
                tenant('id')
            );

            DB::transaction(function () use ($creatorRequest) {
                ($this->creator)($creatorRequest);
            });

            return new JsonResponse(null, 201);
        } catch (ValidationException $e) {
            return new JsonResponse([
                'title' => 'Validation Error',
                'status' => JsonResponse::HTTP_BAD_REQUEST,
                'detail' => 'The given data was invalid.',
                'errors' => $e->errors(),
            ], JsonResponse::HTTP_BAD_REQUEST);
        } catch (UnauthorizedException) {
            return response()->json([
                "title" => "Unauthorized",
                "status" => JsonResponse::HTTP_FORBIDDEN,
                "detail" => "You do not have permission to view this resource.",
            ], JsonResponse::HTTP_FORBIDDEN);
        } catch (Exception $e) {
            return new JsonResponse([
                'title' => 'Internal Server Error',
                'status' => JsonResponse::HTTP_INTERNAL_SERVER_ERROR,
                'detail' => 'An unexpected error occurred while processing your request.'
            ], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
