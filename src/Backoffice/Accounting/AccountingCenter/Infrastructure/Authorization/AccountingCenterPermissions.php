<?php

namespace MedineTech\Backoffice\Accounting\AccountingCenter\Infrastructure\Authorization;

enum AccountingCenterPermissions: string
{
    case CREATE = 'backoffice.accounting.accounting-centers.create';
    case VIEW = 'backoffice.accounting.accounting-centers.view';
    case UPDATE = 'backoffice.accounting.accounting-centers.update';
    public function label(): string
    {
        return match ($this) {
            self::CREATE => 'Create Accounting Center',
            self::VIEW => 'View Accounting Center',
            self::UPDATE => 'Update Accounting Center',
        };
    }
}
