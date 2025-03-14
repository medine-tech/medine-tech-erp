<?php

declare(strict_types=1);

namespace MedineTech\Backoffice\Security\Roles\Domain;

use DomainException;

final class RoleNotFound extends DomainException
{
    public function __construct(int $id)
    {
        parent::__construct("The role with id <$id> does not exist.");
    }
}
