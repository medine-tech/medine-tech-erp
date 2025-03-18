<?php

namespace MedineTech\Backoffice\Security\RolePermissions\Infrastructure\Authorization;

enum RolePermissionPermissions: string
{
    case CREATE = 'backoffice.security.role-permissions.create';
    case DELETE = 'backoffice.security.role-permissions.delete';

    public function label(): string
    {
        return match ($this) {
            self::CREATE => 'Create role permissions',
            self::DELETE => 'Delete role permissions',
        };
    }
}
