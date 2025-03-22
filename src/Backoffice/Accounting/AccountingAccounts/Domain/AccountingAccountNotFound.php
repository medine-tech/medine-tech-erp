<?php

declare(strict_types=1);

namespace MedineTech\Backoffice\Accounting\AccountingAccounts\Domain;

use MedineTech\Shared\Domain\DomainException;

final class AccountingAccountNotFound extends DomainException
{
    public function __construct(public readonly string $id)
    {
        parent::__construct();
    }

    public function errorCode(): string
    {
        return 'accounting_account_not_found';
    }

    public function errorMessage(): string
    {
        return "Accounting Account with ID $this->id does not exist";
    }
}
