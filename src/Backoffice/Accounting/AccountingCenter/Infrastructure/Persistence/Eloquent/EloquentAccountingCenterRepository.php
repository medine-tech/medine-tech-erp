<?php

declare(strict_types=1);

namespace MedineTech\Backoffice\Accounting\AccountingCenter\Infrastructure\Persistence\Eloquent;

use MedineTech\Backoffice\Accounting\AccountingCenter\Domain\AccountingCenter;
use MedineTech\Backoffice\Accounting\AccountingCenter\Domain\AccountingCenterRepository;

final class EloquentAccountingCenterRepository implements AccountingCenterRepository
{
    public function save(AccountingCenter $accountingCenter): void
    {
        $model = AccountingCenterModel::find($accountingCenter->id());
        $primitives = $accountingCenter->toPrimitives();

        $model
            ? $model->update($primitives)
            : AccountingCenterModel::create($primitives);
    }
}
