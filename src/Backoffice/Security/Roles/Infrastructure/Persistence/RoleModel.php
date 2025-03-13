<?php

namespace MedineTech\Backoffice\Security\Roles\Infrastructure\Persistence;

use Illuminate\Database\Eloquent\Builder;
use Spatie\Permission\Models\Role;

class RoleModel extends Role
{
    protected $table = 'roles';
    public $incrementing = true;
    protected $keyType = 'string';
    protected $fillable = [
        'id',
        'code',
        'name',
        'description',
        'status',
        'creator_id',
        'updater_id',
        'company_id',
    ];

    public function scopeFromFilters(Builder $builder, array $filters): void
    {
        (new RoleFilters())->apply($builder, $filters);
    }
}
