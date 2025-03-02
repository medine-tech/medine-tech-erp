<?php

declare(strict_types=1);

namespace MedineTech\Backoffice\Users\Domain;

use DomainException;

final class UserDoesNotExists extends DomainException
{
    public function __construct(string $email)
    {
        parent::__construct(sprintf('User with email <%s> does not exists', $email));
    }
}
