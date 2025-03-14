<?php

namespace MedineTech\Backoffice\Security\Roles\Infrastructure\Authorization;

enum RolesPermissions: string
{
    case CREATE = 'backoffice.security.roles.create';
    case VIEW = 'backoffice.security.roles.view';
    case UPDATE = 'backoffice.security.roles.update';

    public function label(): string
    {
        return match ($this) {
            self::CREATE => 'Create roles',
            self::VIEW => 'View roles',
            self::UPDATE => 'Update roles',
        };
    }
}
