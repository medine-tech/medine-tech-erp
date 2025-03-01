<?php

declare(strict_types=1);

namespace MedineTech\Companies\Domain;

use DomainException;

final class CompanyNotFound extends DomainException
{
    public function __construct(string $id)
    {
        parent::__construct("The company with id <$id> does not exist.");
    }
}
