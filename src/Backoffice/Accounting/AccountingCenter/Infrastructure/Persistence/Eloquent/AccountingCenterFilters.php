<?php
declare(strict_types=1);

namespace MedineTech\Backoffice\Accounting\AccountingCenter\Infrastructure\Persistence\Eloquent;

use Illuminate\Database\Eloquent\Builder;
use MedineTech\Shared\Infrastructure\Persistence\Eloquent\EloquentFilters;

final class AccountingCenterFilters extends EloquentFilters
{
    protected function companyId($value): void
    {
        $value = (array) $this->getValue($value);
        $this->builder->whereIn('company_id', $value);
    }
}
