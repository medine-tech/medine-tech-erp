<?php

declare(strict_types=1);

namespace MedineTech\Backoffice\Companies\Infrastructure\Persistence\Eloquent;

use Illuminate\Database\Eloquent\Builder;
use MedineTech\Shared\Infrastructure\Persistence\Eloquent\EloquentFilters;

final class CompanyFilters extends EloquentFilters
{
    protected function userId($value): void
    {
        $value = $this->getValue($value);
        $this->builder->whereHas('company_users', function (Builder $query) use ($value) {
            $query->whereIn('user_id', $value);
        });
    }
}
