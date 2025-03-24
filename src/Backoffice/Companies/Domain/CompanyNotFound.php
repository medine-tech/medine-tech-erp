<?php

declare(strict_types=1);

namespace MedineTech\Backoffice\Companies\Domain;

use MedineTech\Shared\Domain\DomainException;

final class CompanyNotFound extends DomainException
{
    public function __construct(public readonly string $id)
    {
        parent::__construct();
    }

    public function errorCode(): string
    {
        return 'company_not_found';
    }

    public function errorMessage(): string
    {
        return "Company with ID $this->id does not exist";
    }
}
