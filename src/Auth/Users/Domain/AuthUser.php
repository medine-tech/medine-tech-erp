<?php

declare(strict_types=1);

namespace MedineTech\Auth\Users\Domain;

use MedineTech\Backoffice\Users\Domain\UserEmail;
use MedineTech\Shared\Domain\Aggregate\AggregateRoot;

final class AuthUser extends AggregateRoot
{
    private UserEmail $email;
    public function __construct(
        private readonly string $id,
        private string $name,
        string $email,
        private readonly string $password,
        private readonly string $defaultCompanyId
    ) {
        $this->email = new UserEmail($email);
    }

    public static function create(
        string $id,
        string $name,
        string $email,
        string $password,
        string $defaultCompanyId
    ): self {
        $user = new self($id, $name, $email, $password, $defaultCompanyId);

        $user->record(new AuthUserCreatedDomainEvent(
            $user->id(),
            $user->name(),
            $user->email(),
            $user->defaultCompanyId()
        ));

        return $user;
    }

    public function id(): string
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

    public function password(): string
    {
        return $this->password;
    }

    public function defaultCompanyId(): string
    {
        return $this->defaultCompanyId;
    }
}
