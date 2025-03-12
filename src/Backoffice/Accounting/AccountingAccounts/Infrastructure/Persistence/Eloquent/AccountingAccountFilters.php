<?php

declare(strict_types=1);

namespace MedineTech\Backoffice\Accounting\AccountingAccounts\Infrastructure\Persistence\Eloquent;

use MedineTech\Shared\Infrastructure\Persistence\Eloquent\EloquentFilters;
use Illuminate\Database\Eloquent\Builder;

final class AccountingAccountFilters extends EloquentFilters
{
    protected function companyId($value): void
    {
        $value = $this->getValue($value);
        $this->builder->whereHas("company_users", function (Builder $companyUsers) use ($value) {
            $companyUsers->whereIn("company_id", $value);
        });
    }
}
