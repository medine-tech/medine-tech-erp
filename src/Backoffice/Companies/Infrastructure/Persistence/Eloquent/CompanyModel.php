<?php

declare(strict_types=1);

namespace MedineTech\Backoffice\Companies\Infrastructure\Persistence\Eloquent;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use MedineTech\Backoffice\CompanyUsers\Infrastructure\Persistence\Eloquent\CompanyUserModel;
use Stancl\Tenancy\Database\Models\Tenant;

final class CompanyModel extends Tenant
{
    protected $table = 'companies';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id',
//        'name',
        'data',
    ];

    protected $casts = [
        'data' => 'array',
    ];

    /**
     * @phpstan-return HasMany<CompanyUserModel, CompanyModel>
     */
    public function company_users(): HasMany
    {
        return $this->hasMany(CompanyUserModel::class, 'company_id');
    }

    /**
     * @param Builder<CompanyModel> $builder
     * @param array<string, mixed> $filters
     */
    public function scopeFromFilters(Builder $builder, array $filters): void
    {
        (new CompanyFilters())->apply($builder, $filters);
    }
}
