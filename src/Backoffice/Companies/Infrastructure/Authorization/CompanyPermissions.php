<?php

namespace MedineTech\Backoffice\Companies\Infrastructure\Authorization;

enum CompanyPermissions: string
{
    case CREATE = 'backoffice.companies.create';
    case UPDATE = 'backoffice.companies.update';
    case VIEW = 'backoffice.companies.view';

    public function label(): string
    {
        return match ($this) {
            self::CREATE => 'Create Company',
            self::UPDATE => 'Update Company',
            self::VIEW => 'View Company',
        };
    }
}
