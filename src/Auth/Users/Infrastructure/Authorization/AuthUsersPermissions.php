<?php

namespace MedineTech\Auth\Users\Infrastructure\Authorization;

enum AuthUsersPermissions: string
{
    case VIEW = 'auth.users.view';

    public function label(): string
    {
        return match ($this) {
            self::VIEW => 'View User',
        };
    }
}
