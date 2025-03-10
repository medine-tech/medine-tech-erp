<?php

declare(strict_types=1);

namespace MedineTech\Backoffice\Accounting\AccountingAccounts\Infrastructure\Persistence\Eloquent;

use MedineTech\Backoffice\Accounting\AccountingAccounts\Domain\AccountingAccount;
use MedineTech\Backoffice\Accounting\AccountingAccounts\Domain\AccountingAccountRepository;


final class EloquentAccountingAccountRepository implements AccountingAccountRepository
{
    public function save(AccountingAccount $accountingAccount): void
    {
        $model = AccountingAccountModel::find($accountingAccount->id());
        $primitives = $accountingAccount->toPrimitives();

        $model
            ? $model->update($primitives)
            : AccountingAccountModel::create($primitives);
    }
}
