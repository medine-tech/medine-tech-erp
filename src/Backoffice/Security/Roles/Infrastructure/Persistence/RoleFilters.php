<?php

declare(strict_types=1);

namespace MedineTech\Backoffice\Security\Roles\Infrastructure\Persistence;

use Illuminate\Database\Eloquent\Builder;
use MedineTech\Shared\Infrastructure\Persistence\Eloquent\EloquentFilters;

/**
 * @extends EloquentFilters<\MedineTech\Backoffice\Security\Roles\Infrastructure\Persistence\RoleModel>
 */
final class RoleFilters extends EloquentFilters
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
