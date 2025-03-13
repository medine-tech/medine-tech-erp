<?php

declare(strict_types=1);

namespace MedineTech\Backoffice\Security\Roles\Infrastructure\Persistence;

use Illuminate\Database\Eloquent\Builder;
use MedineTech\Shared\Infrastructure\Persistence\Eloquent\EloquentFilters;

final class RoleFilters extends EloquentFilters
{
    protected function companyId($value): void
    {
        $value = $this->getValue($value);
        $this->builder->whereHas('company_users', function (Builder $query) use ($value) {
            $query->whereIn('company_id', $value);
        });
    }
}
