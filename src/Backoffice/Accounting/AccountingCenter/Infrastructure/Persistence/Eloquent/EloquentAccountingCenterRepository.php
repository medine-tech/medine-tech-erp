<?php
declare(strict_types=1);

namespace MedineTech\Backoffice\Accounting\AccountingCenter\Infrastructure\Persistence\Eloquent;

use MedineTech\Backoffice\Accounting\AccountingCenter\Domain\AccountingCenter;
use MedineTech\Backoffice\Accounting\AccountingCenter\Domain\AccountingCenterRepository;
use Illuminate\Support\Facades\Log;

final class EloquentAccountingCenterRepository implements AccountingCenterRepository
{
    public function save(AccountingCenter $accountingCenter): void
    {
        try {
            $data = [
                'id' => $accountingCenter->id(),
                'code' => $accountingCenter->code(),
                'name' => $accountingCenter->name(),
                'description' => $accountingCenter->description(),
                'status' => $accountingCenter->status(),
                'parent_id' => $accountingCenter->parentId(),
                'company_id' => $accountingCenter->companyId(),
                'creator_id' => $accountingCenter->creatorId(),
                'updater_id' => $accountingCenter->updaterId(),
            ];

            AccountingCenterModel::updateOrCreate(
                ['id' => $accountingCenter->id()],
                $data
            );
        } catch (\Exception $e) {
            Log::error('Failed to save accounting center: ' . $e->getMessage());
            throw new \RuntimeException('Failed to save accounting center', 0, $e);
        }
    }
}
