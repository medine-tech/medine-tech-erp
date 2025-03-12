<?php

declare(strict_types=1);

namespace MedineTech\Backoffice\Accounting\AccountingAccounts\Application\Search;

use MedineTech\Backoffice\Accounting\AccountingAccounts\Domain\AccountingAccount;
use MedineTech\Backoffice\Accounting\AccountingAccounts\Domain\AccountingAccountRepository;
use function Lambdish\Phunctional\map;

class AccountingAccountsSearcher
{
    public function __construct(
        private readonly AccountingAccountRepository $repository
    ) {
    }

    public function __invoke(AccountingAccountsSearcherRequest $request): AccountingAccountsSearcherResponse
    {
        $result = $this->repository->search($request->filters());

        return new AccountingAccountsSearcherResponse(
            map(function (AccountingAccount $accountingAccount) {
                return new AccountingAccountSearcherResponse(
                    $accountingAccount->id(),
                    $accountingAccount->code(),
                    $accountingAccount->name(),
                    $accountingAccount->description(),
                    $accountingAccount->type(),
                    $accountingAccount->status(),
                    $accountingAccount->parentId(),
                    $accountingAccount->creatorId(),
                    $accountingAccount->updaterId(),
                    $accountingAccount->companyId()
                );
            }, $result["items"]),
            $result["total"],
            $result["perPage"],
            $result["currentPage"]
        );
    }
}
