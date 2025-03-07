<?php

declare(strict_types=1);

namespace MedineTech\Backoffice\Users\Domain;

use DomainException;

final class UserNotFound extends DomainException
{
    public function __construct(int $id)
    {
        parent::__construct("The User with id <$id> does not exist.");
    }
}
