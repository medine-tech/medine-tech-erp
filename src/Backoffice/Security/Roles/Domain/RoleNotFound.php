<?php

declare(strict_types=1);

namespace MedineTech\Backoffice\Security\Roles\Domain;

use MedineTech\Shared\Domain\DomainException;

final class RoleNotFound extends DomainException
{
    public function __construct(public readonly int $id)
    {
        parent::__construct();
    }

    public function errorCode(): string
    {
        return 'role_not_found';
    }

    public function errorMessage(): string
    {
        return "The role with id $this->id does not exist.";
    }
}
