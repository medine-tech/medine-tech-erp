<?php

declare(strict_types=1);

namespace MedineTech\Backoffice\Accounting\AccountingAccounts\Infrastructure\Persistence\Eloquent;

use MedineTech\Shared\Infrastructure\Persistence\Eloquent\EloquentFilters;
use Illuminate\Database\Eloquent\Builder;

/**
 * @extends EloquentFilters<AccountingAccountModel>
 */
final class AccountingAccountFilters extends EloquentFilters
{
    /**
     * @param string|array<int, string> $value
     */
    protected function companyId($value): void
    {
        $value = $this->getValue($value);
        $this->builder->whereIn('company_id', $value);
    }
}
