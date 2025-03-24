<?php

namespace MedineTech\Auth\Companies\Infrastructure\Authorization;

enum AuthCompaniesPermissions: string
{
    case VIEW = 'auth.companies.view';

    public function label(): string
    {
        return match ($this) {
            self::VIEW => 'View Company',
        };
    }
}
