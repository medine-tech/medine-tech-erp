<?php

declare(strict_types=1);

namespace MedineTech\Backoffice\Accounting\AccountingAccounts\Infrastructure\Persistence\Eloquent;

use Closure;
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
                'creator_id' => $accountingAccount->creatorId(),
                'updater_id' => $accountingAccount->updaterId(),
                'company_id' => $accountingAccount->companyId()
            ];

            AccountingAccountModel::updateOrCreate(
                ['id' => $accountingAccount->id()],
                $data
            );

        } catch (Exception $e) {
            throw new RuntimeException("Failed to save accounting account: " . $e->getMessage(), 0, $e);
        }
    }

    public function find(string $id): ?AccountingAccount
    {
        $model = AccountingAccountModel::find($id);

        if (!$model) {
            return null;
        }

        $data = $model->toArray();
        return $this->fromDatabase($data);
    }


    private function fromDatabase(array $data): AccountingAccount
    {
        return AccountingAccount::fromPrimitives([
            'id' => $data['id'],
            'code' => $data['code'],
            'name' => $data['name'],
            'description' => $data['description'],
            'type' => $data['type'],
            'status' => $data['status'],
            'parent_id' => $data['parent_id'],
            'creator_id' => $data['creator_id'],
            'updater_id' => $data['updater_id'],
            'company_id' => $data['company_id']
        ]);
    }
}
