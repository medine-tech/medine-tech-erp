<?php

declare(strict_types=1);

namespace MedineTech\Backoffice\Users\Infrastructure\Persistence\Eloquent;

use Illuminate\Database\Eloquent\Builder;
use MedineTech\Shared\Infrastructure\Persistence\Eloquent\EloquentFilters;

/**
 * @extends EloquentFilters<\App\Models\User>
 */
final class UserFilters extends EloquentFilters
{
    /**
     * @param string|array<int, string> $value
     */
    protected function companyId($value): void
    {
        $value = $this->getValue($value);
        $this->builder->whereHas("company_users", function (Builder $companyUsers) use ($value) {
            $companyUsers->whereIn("company_id", $value);
        });
    }
}
