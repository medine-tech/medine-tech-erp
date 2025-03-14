<?php

declare(strict_types=1);

namespace MedineTech\Backoffice\Accounting\AccountingAccounts\Application\Update;

use MedineTech\Backoffice\Accounting\AccountingAccounts\Domain\AccountingAccountNotFound;
use MedineTech\Backoffice\Accounting\AccountingAccounts\Domain\AccountingAccountRepository;

final readonly class AccountingAccountUpdater
{
    public function __construct(
        private AccountingAccountRepository $repository,
    )
    {
    }

    public function __invoke(AccountingAccountUpdaterRequest $request): void
    {
        $accountingAccount = $this->repository->find($request->id());

        if ($accountingAccount === null) {
            throw new AccountingAccountNotFound($request->id());
        }

        $accountingAccount->changeName($request->name());
        $accountingAccount->changeDescription($request->description());
        $accountingAccount->changeType($request->type());
        $accountingAccount->changeStatus($request->status());
        $accountingAccount->changeUpdaterId($request->updaterId());
        $accountingAccount->changeParentId($request->parentId());

        $this->repository->save($accountingAccount);
    }
}
