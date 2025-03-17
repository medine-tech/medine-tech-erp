<?php

declare(strict_types=1);

namespace MedineTech\Backoffice\Security\UserRoles\Infrastructure\Persintence\Eloquent;

use MedineTech\Backoffice\Security\Roles\Infrastructure\Persistence\RoleModel;
use MedineTech\Backoffice\Security\UserRoles\Domain\UserRoleRepository;

final class EloquentUserRoleRepository implements UserRoleRepository
{
    public function attachPermission(string $roleId, string $permissionId): void
    {
        $role = RoleModel::find($roleId);
        $role->permissions()->attach($permissionId);
    }

    public function detachPermission(string $roleId, string $permissionId): void
    {
        $role = RoleModel::find($roleId);
        $role->permissions()->detach($permissionId);
    }
}
