<?php

namespace MedineTech\Backoffice\Security\Roles\Infrastructure\Persistence;

use Illuminate\Database\Eloquent\Builder;
use Spatie\Permission\Models\Role;
use MedineTech\Backoffice\Security\Roles\Infrastructure\Persistence\RoleFilters;

class RoleModel extends Role
{
    protected $table = 'roles';
    protected $fillable = [
        'code',
        'name',
        'description',
        'status',
        'creator_id',
        'updater_id',
        'company_id',
        'guard_name'
    ];

    /**
     * @param Builder<RoleModel> $builder
     * @param array<string, mixed> $filters
     */
    public function scopeFromFilters(Builder $builder, array $filters): void
    {
        (new RoleFilters())->apply($builder, $filters);
    }
}
