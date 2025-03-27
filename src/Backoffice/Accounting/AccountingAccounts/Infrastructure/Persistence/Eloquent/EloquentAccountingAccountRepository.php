<?php

declare(strict_types=1);

namespace MedineTech\Backoffice\Accounting\AccountingAccounts\Infrastructure\Persistence\Eloquent;

use Closure;
use Exception;
use MedineTech\Backoffice\Accounting\AccountingAccounts\Domain\AccountingAccount;
use MedineTech\Backoffice\Accounting\AccountingAccounts\Domain\AccountingAccountRepository;
use RuntimeException;
use function Lambdish\Phunctional\map;


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

        $accountingAccountData = $model->toArray();

        $fromDatabase = $this->fromDatabase();
        return $fromDatabase($accountingAccountData);
    }

    public function search(array $filters, int $perPage = 20): array
    {
        $paginator = AccountingAccountModel::fromFilters($filters)
            ->paginate($perPage);

        return [
            'items' => map($this->fromDatabase(), $paginator->items()),
            'total' => $paginator->total(),
            'perPage' => $paginator->perPage(),
            'currentPage' => $paginator->currentPage(),
        ];
    }

    private function fromDatabase(): Closure
    {
        return fn(AccountingAccountModel $model) => AccountingAccount::fromPrimitives([
            'id' => $model['id'],
            'code' => $model['code'],
            'name' => $model['name'],
            'description' => $model['description'],
            'type' => $model['type'],
            'status' => $model['status'],
            'parent_id' => $model['parent_id'],
            'creator_id' => $model['creator_id'],
            'updater_id' => $model['updater_id'],
            'company_id' => $model['company_id']
        ]);
    }
}
