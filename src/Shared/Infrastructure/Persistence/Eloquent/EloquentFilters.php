<?php

declare(strict_types=1);

namespace MedineTech\Shared\Infrastructure\Persistence\Eloquent;

use Illuminate\Database\Eloquent\Builder;

/**
 * @template TModel of \Illuminate\Database\Eloquent\Model
 */
abstract class EloquentFilters
{
    /**
     * @var Builder<TModel>
     */
    protected Builder $builder;

    /**
     * @param Builder<TModel> $builder
     * @param array<string, mixed> $filters
     */
    public function apply(Builder $builder, array $filters): void
    {
        $this->builder = $builder;
        $filters = array_filter($filters, fn($value) => $value !== null);

        foreach ($filters as $key => $value) {
            if (!method_exists($this, $key)) {
                continue;
            }

            call_user_func_array([$this, $key], [$value]);
        }
    }

    /**
     * @param mixed $value
     * @return array<int, mixed>
     */
    protected function getValue($value): array
    {
        return is_array($value) ? $value : [$value];
    }
}
