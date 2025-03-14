<?php

declare(strict_types=1);

namespace MedineTech\Backoffice\Accounting\AccountingAccounts\Application\Find;

use MedineTech\Backoffice\Accounting\AccountingAccounts\Domain\AccountingAccountNotFound;
use MedineTech\Backoffice\Accounting\AccountingAccounts\Domain\AccountingAccountRepository;

final readonly class AccountingAccountFinder
{
    public function __construct(
        private readonly AccountingAccountRepository $repository
    )
    {
    }

    public function __invoke(AccountingAccountFinderRequest $request): AccountingAccountFinderResponse
    {
        $accountingAccount = $this->repository->find($request->id());

        if (null === $accountingAccount) {
            throw new AccountingAccountNotFound($request->id());
        }

        return new AccountingAccountFinderResponse(
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
    }
}
