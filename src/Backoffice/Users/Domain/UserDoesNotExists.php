<?php

declare(strict_types=1);

namespace MedineTech\Backoffice\Users\Domain;

use MedineTech\Shared\Domain\DomainException;

final class UserDoesNotExists extends DomainException
{
    public function __construct(public readonly string $email)
    {
        parent::__construct();
    }

    public function errorCode(): string
    {
        return 'user_does_not_exists';
    }

    public function errorMessage(): string
    {
        return "User with email $this->email does not exists";
    }
}
