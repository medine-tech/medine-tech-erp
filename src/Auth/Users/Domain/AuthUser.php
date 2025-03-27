<?php

declare(strict_types=1);

namespace MedineTech\Auth\Users\Domain;

use MedineTech\Shared\Domain\Aggregate\AggregateRoot;

final class AuthUser extends AggregateRoot
{
    private AuthUserEmail $email;
    public function __construct(
        private readonly int $id,
        private string $name,
        string $email,
        private readonly string $defaultCompanyId
    ) {
        $this->email = new AuthUserEmail($email);
    }

    public function id(): int
    {
        return $this->id;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function email(): string
    {
        return $this->email->value();
    }

    public function defaultCompanyId(): string
    {
        return $this->defaultCompanyId;
    }
}
