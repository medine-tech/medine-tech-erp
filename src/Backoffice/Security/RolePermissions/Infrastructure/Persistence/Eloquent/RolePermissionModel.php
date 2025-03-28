<?php

declare(strict_types=1);

namespace MedineTech\Backoffice\Security\RolePermissions\Infrastructure\Persistence\Eloquent;

use Illuminate\Database\Eloquent\Model;

final class RolePermissionModel extends Model
{
    protected $table = 'role_has_permissions';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'permission_id',
        'role_id'
    ];
}
