<?php

declare(strict_types=1);

namespace MedineTech\Backoffice\Users\Infrastructure\Authorization;

enum UsersPermissions: string
{
    case CREATE = 'backoffice.users.create';
    case UPDATE = 'backoffice.users.update';
    case VIEW = 'backoffice.users.view';

    public function label(): string
    {
        return match ($this) {
            self::CREATE => 'Create User',
            self::UPDATE => 'Update User',
            self::VIEW => 'View User',
        };
    }
}
