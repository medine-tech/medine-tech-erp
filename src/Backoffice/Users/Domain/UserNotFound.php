<?php

declare(strict_types=1);

namespace MedineTech\Backoffice\Users\Domain;

use MedineTech\Shared\Domain\DomainException;

final class UserNotFound extends DomainException
{
    private int $id;

    public function __construct(int $id)
    {
        $this->id = $id;
        parent::__construct();
    }

    public function errorCode(): string
    {
        return 'user_not_found';
    }

    public function errorMessage(): string
    {
        return "User with ID {$this->id} does not exist";
    }
}
