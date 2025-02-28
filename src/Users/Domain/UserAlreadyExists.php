<?php

declare(strict_types=1);

namespace MedineTech\Users\Domain;

use DomainException;

final class UserAlreadyExists extends DomainException
{
    public function __construct(string $email)
    {
        parent::__construct(sprintf('User with email <%s> already exists', $email));
    }
}
