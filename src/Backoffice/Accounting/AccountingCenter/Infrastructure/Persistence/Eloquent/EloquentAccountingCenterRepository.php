<?php
declare(strict_types=1);

namespace MedineTech\Backoffice\Accounting\AccountingCenter\Infrastructure\Persistence\Eloquent;

use MedineTech\Backoffice\Accounting\AccountingCenter\Domain\AccountingCenter;
use MedineTech\Backoffice\Accounting\AccountingCenter\Domain\AccountingCenterRepository;
use Illuminate\Support\Facades\Log;
use function Lambdish\Phunctional\map;

final class EloquentAccountingCenterRepository implements AccountingCenterRepository
{
    public function save(AccountingCenter $accountingCenter): void
    {
        try {
            $data = [
                'id'           => $accountingCenter->id(),
                'code'         => $accountingCenter->code(),
                'name'         => $accountingCenter->name(),
                'description'  => $accountingCenter->description(),
                'status'       => $accountingCenter->status(),
                'parent_id'    => $accountingCenter->parentId(),
                'creator_id'   => $accountingCenter->creatorId(),
                'updater_id'   => $accountingCenter->updaterId(),
                'company_id'   => $accountingCenter->companyId()
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

    public function find(string $id): ?AccountingCenter
    {
        $model = AccountingCenterModel::find($id);
        if (!$model) {
            return null;
        }
        $data = $model->toArray();
        $fromDatabase = $this->fromDatabase();
        return $fromDatabase($data);
    }

    public function search(array $filters, int $perPage = 20): array
    {
        $paginator = AccountingCenterModel::fromFilters($filters)
            ->paginate($perPage);

        return [
            'items' => map($this->fromDatabase(), $paginator->items()),
            'total' => $paginator->total(),
            'perPage' => $paginator->perPage(),
            'currentPage' => $paginator->currentPage(),
        ];
    }

    private function fromDatabase(): \Closure
    {
        return function ($data): AccountingCenter {
            if ($data instanceof AccountingCenterModel) {
                $data = $data->toArray();
            }
            return AccountingCenter::fromPrimitives([
                'id'           => (string) $data['id'],
                'code'         => (string) $data['code'],
                'name'         => (string) $data['name'],
                'description'  => $data['description'] ?? null,
                'status'       => (string) $data['status'],
                'parent_id'    => $data['parent_id'] ?? null,
                'creator_id'   => (int) $data['creator_id'],
                'updater_id'   => (int) $data['updater_id'],
                'company_id'   => (string) $data['company_id'],
            ]);
        };
    }
}
