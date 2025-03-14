<?php

declare(strict_types=1);

namespace MedineTech\Backoffice\Accounting\AccountingAccounts\Domain;

use DomainException;

final class AccountingAccountNotFound extends DomainException
{
    public function __construct(string $id)
    {
        parent::__construct("The accounting account with id <$id> does not exist.");
    }
}
