<?php

declare(strict_types=1);

namespace MedineTech\Backoffice\Accounting\AccountingAccounts\Infrastructure\Persistence\Eloquent;

use Exception;
use MedineTech\Backoffice\Accounting\AccountingAccounts\Domain\AccountingAccount;
use MedineTech\Backoffice\Accounting\AccountingAccounts\Domain\AccountingAccountRepository;
use RuntimeException;


final class EloquentAccountingAccountRepository implements AccountingAccountRepository
{
    public function save(AccountingAccount $accountingAccount): void
    {
        try {
            $data = [
                'id' => $accountingAccount->id(),
                'code' => $accountingAccount->code(),
                'name' => $accountingAccount->name(),
                'description' => $accountingAccount->description(),
                'type' => $accountingAccount->type(),
                'status' => $accountingAccount->status(),
                'parent_id' => $accountingAccount->parentId(),
                'company_id' => $accountingAccount->companyId(),
                'creator_id' => $accountingAccount->creatorId(),
                'updater_id' => $accountingAccount->updaterId()
            ];

            AccountingAccountModel::updateOrCreate(
                ['id' => $accountingAccount->id()],
                $data
            );

        } catch (Exception $e) {
            throw new RuntimeException("Failed to save accounting account: " . $e->getMessage(), 0, $e);
        }
    }
}
