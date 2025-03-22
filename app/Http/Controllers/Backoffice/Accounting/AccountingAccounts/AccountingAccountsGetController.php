<?php

declare(strict_types=1);

namespace App\Http\Controllers\Backoffice\Accounting\AccountingAccounts;

use App\Http\Controllers\ApiController;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use MedineTech\Backoffice\Accounting\AccountingAccounts\Application\Search\AccountingAccountsSearcher;
use MedineTech\Backoffice\Accounting\AccountingAccounts\Application\Search\AccountingAccountsSearcherRequest;
use MedineTech\Backoffice\Accounting\AccountingAccounts\Infrastructure\Authorization\AccountingAccountsPermissions;
use Spatie\Permission\Exceptions\UnauthorizedException;
use Symfony\Component\HttpFoundation\Response;

/**
 * @OA\Get(
 *     path="/api/backoffice/{tenant}/accounting/accounting-accounts",
 *     summary="Search accounting accounts based on filters",
 *     tags={"Backoffice - Accounting - Accounting Accounts"},
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
 *         description="Successful retrieval of accounting accounts list",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="items", type="array",
 *                 @OA\Items(
 *                     type="object",
 *                     @OA\Property(property="id", type="string", example="123e4567-e89b-12d3-a456-426655440000"),
 *                     @OA\Property(property="code", type="string", example="101"),
 *                     @OA\Property(property="name", type="string", example="Cash Account"),
 *                     @OA\Property(property="description", type="string", example="Main cash account", nullable=true),
 *                     @OA\Property(property="type", type="integer", example=1, description="1 = asset, 2 = liability, 3 = equity, 4 = revenue, 5 = expense"),
 *                     @OA\Property(property="status", type="string", example="ACTIVE", description="Account status"),
 *                     @OA\Property(property="parent_id", type="string", example="123e4567-e89b-12d3-a456-426655440001", nullable=true),
 *                     @OA\Property(property="creator_id", type="integer", example=1),
 *                     @OA\Property(property="updater_id", type="integer", example=1),
 *                     @OA\Property(property="company_id", type="string", example="company-123")
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
final class AccountingAccountsGetController extends ApiController
{
    public function __construct(
        private readonly AccountingAccountsSearcher $searcher
    ) {
    }

    public function __invoke(Request $request): JsonResponse
    {
        return $this->execute(function () use ($request) {
            if (!$request->user()->can(AccountingAccountsPermissions::VIEW)) {
                throw new UnauthorizedException(403);
            }

            $filters = (array)$request->query();
            $filters["company_id"] = $request->user()->id;

            $searcherRequest = new AccountingAccountsSearcherRequest($filters);
            $searcherResponse = ($this->searcher)($searcherRequest);

            $accounts = array_map(function ($account) {
                return [
                    "id" => $account->id(),
                    "code" => $account->code(),
                    "name" => $account->name(),
                    "description" => $account->description(),
                    "type" => $account->type(),
                    "status" => $account->status(),
                    "parent_id" => $account->parentId(),
                    "creator_id" => $account->creatorId(),
                    "updater_id" => $account->updaterId(),
                    "company_id" => $account->companyId()
                ];
            }, $searcherResponse->items());

            return new JsonResponse([
                "items" => $accounts,
                "total" => $searcherResponse->total(),
                "per_page" => $searcherResponse->perPage(),
                "current_page" => $searcherResponse->currentPage()
            ], Response::HTTP_OK);
        });
    }

    protected function exceptions(): array
    {
        return [
            UnauthorizedException::class => Response::HTTP_FORBIDDEN,
        ];
    }

    protected function exceptionDetail(\Exception $error): string
    {
        if ($error instanceof UnauthorizedException) {
            return 'You do not have permission to view this resource.';
        }

        return parent::exceptionDetail($error);
    }
}
