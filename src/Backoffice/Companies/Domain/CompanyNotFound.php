<?php

declare(strict_types=1);

namespace MedineTech\Backoffice\Companies\Domain;

use DomainException;

final class CompanyNotFound extends DomainException
{
    public function __construct(string $id)
    {
        parent::__construct("The company with id <$id> does not exist.");
    }
}
