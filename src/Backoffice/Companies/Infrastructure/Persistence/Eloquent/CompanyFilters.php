<?php

declare(strict_types=1);

namespace MedineTech\Backoffice\Companies\Infrastructure\Persistence\Eloquent;

use Illuminate\Database\Eloquent\Builder;
use MedineTech\Shared\Infrastructure\Persistence\Eloquent\EloquentFilters;

/**
 * @extends EloquentFilters<\MedineTech\Backoffice\Companies\Infrastructure\Persistence\Eloquent\CompanyModel>
 */
final class CompanyFilters extends EloquentFilters
{
    /**
     * @param string|array<int, string> $value
     */
    protected function userId($value): void
    {
        $value = $this->getValue($value);
        $this->builder->whereHas('company_users', function (Builder $query) use ($value) {
            $query->whereIn('user_id', $value);
        });
    }

    /**
     * @param string $value
     */
    protected function name(string $value): void
    {
        $this->builder->whereRaw('JSON_EXTRACT(data, "$.name") LIKE ?', ["%$value%"]);
    }
}
