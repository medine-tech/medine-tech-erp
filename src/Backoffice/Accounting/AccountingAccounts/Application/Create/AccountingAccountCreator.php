<?php

declare(strict_types=1);

namespace MedineTech\Backoffice\Accounting\AccountingAccounts\Application\Create;

use Exception;
use MedineTech\Backoffice\Accounting\AccountingAccounts\Domain\AccountingAccount;
use MedineTech\Backoffice\Accounting\AccountingAccounts\Domain\AccountingAccountRepository;

class AccountingAccountCreator
{
    public function __construct(
        private readonly AccountingAccountRepository $repository
    ) {
    }

    public function __invoke(AccountingAccountCreatorRequest $request): void
    {
        try {
            $accountingAccount = AccountingAccount::create(
                $request->id(),
                $request->name(),
                $request->code(),
                $request->type(),
                $request->parentId(),
                $request->status(),
                $request->companyId()
            );

            $this->repository->save($accountingAccount);
        } catch (Exception $e) {
            throw new (sprintf('Error creating accounting account: %s', $e->getMessage()));
        }
    }
}
