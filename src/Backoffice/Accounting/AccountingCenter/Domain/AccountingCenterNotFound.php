<?php

declare(strict_types=1);

namespace MedineTech\Backoffice\Accounting\AccountingCenter\Domain;

use DomainException;

final class AccountingCenterNotFound extends DomainException
{
    public function __construct(string $id)
    {
        parent::__construct("The Accounting with id <$id> does not exist.");
    }
}
