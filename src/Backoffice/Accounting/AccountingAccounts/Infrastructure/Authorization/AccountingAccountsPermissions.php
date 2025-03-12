<?php

namespace MedineTech\Backoffice\Accounting\AccountingAccounts\Infrastructure\Authorization;

enum AccountingAccountsPermissions: string
{
    case CREATE = 'backoffice.accounting.accounting-accounts.created';
    case UPDATE = 'backoffice.accounting.accounting-accounts.update';
    case VIEW = 'backoffice.accounting.accounting-accounts.view';

    public function label(): string
    {
        return match ($this) {
            self::CREATE => 'Create Accounting Account',
            self::UPDATE => 'Update Accounting Account',
            self::VIEW => 'View Accounting Account',
        };
    }
}
