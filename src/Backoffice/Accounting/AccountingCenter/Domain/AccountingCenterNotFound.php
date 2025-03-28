<?php

declare(strict_types=1);

namespace MedineTech\Backoffice\Accounting\AccountingCenter\Domain;

use MedineTech\Shared\Domain\DomainException;

final class AccountingCenterNotFound extends DomainException
{
    public function __construct(public readonly string $id)
    {
        parent::__construct();
    }

    public function errorCode(): string
    {
        return 'accounting_center_not_found';
    }

    public function errorMessage(): string
    {
        return "Accounting Center with ID $this->id does not exist";
    }
}
