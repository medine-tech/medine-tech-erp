<?php

declare(strict_types=1);

namespace MedineTech\Backoffice\Security\RolePermissions\Infrastructure\Persistence\Eloquent;

use MedineTech\Backoffice\Security\Roles\Domain\RoleNotFound;
use MedineTech\Backoffice\Security\RolePermissions\Domain\RolePermission;
use MedineTech\Backoffice\Security\RolePermissions\Domain\RolePermissionRepository;

final class EloquentRolePermissionRepository implements RolePermissionRepository
{
    public function save(RolePermission $rolePermission): void
    {
        try {
            $rolePermissionModel = new RolePermissionModel();
            $rolePermissionModel->permission_id = $rolePermission->permissionId();
            $rolePermissionModel->role_id = $rolePermission->roleId();

            $rolePermissionModel->save();

        } catch (\Exception $e) {
            throw new \RuntimeException("Failed to save role permission: " . $e->getMessage(), 0, $e);
        }
    }

    public function delete(RolePermission $rolePermission): void
    {
        try {
            RolePermissionModel::where('role_id', $rolePermission->roleId())
                ->where('permission_id', $rolePermission->permissionId())
                ->delete();
        } catch (\Exception $e) {
            throw new \RuntimeException("Failed to delete role permission: " . $e->getMessage(), 0, $e);
        }
    }

}
