<?php

declare(strict_types=1);

namespace MedineTech\Auth\Users\Domain;

use MedineTech\Shared\Domain\DomainException;

final class AuthUserNotFound extends DomainException
{
    public function __construct(public readonly string $id)
    {
        parent::__construct();
    }

    public function errorCode(): string
    {
        return 'user_not_found';
    }

    public function errorMessage(): string
    {
        return "User with ID $this->id does not exist";
    }
}
