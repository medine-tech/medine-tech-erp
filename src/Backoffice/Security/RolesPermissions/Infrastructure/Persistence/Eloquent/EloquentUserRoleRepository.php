<?php

declare(strict_types=1);

namespace MedineTech\Backoffice\Security\RolesPermissions\Infrastructure\Persistence\Eloquent;

use MedineTech\Backoffice\Security\Roles\Domain\RoleNotFound;
use MedineTech\Backoffice\Security\Roles\Infrastructure\Persistence\RoleModel;
use MedineTech\Backoffice\Security\RolesPermissions\Domain\UserRoleRepository;

final class EloquentUserRoleRepository implements UserRoleRepository
{
    public function attachPermission(int $roleId, string $permissionId): void
    {
        $role = RoleModel::find($roleId);

        if (!$role) {
            throw new RoleNotFound($roleId);
        }

        $role->permissions()->attach($permissionId);
    }

    public function detachPermission(int $roleId, string $permissionId): void
    {
        $role = RoleModel::find($roleId);

        if (!$role) {
            throw new RoleNotFound($roleId);
        }

        $role->permissions()->detach($permissionId);
    }
}
