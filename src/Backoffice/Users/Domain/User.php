<?php

declare(strict_types=1);

namespace MedineTech\Backoffice\Users\Domain;

use MedineTech\Shared\Domain\Aggregate\AggregateRoot;

final class User extends AggregateRoot
{
    private UserEmail $email;

    private function __construct(
        private readonly int $id,
        private string $name,
        string $email,
        private readonly string $password,
        private readonly string $defaultCompanyId,
    ) {
        $this->email = new UserEmail($email);
    }

    public static function create(
        int $id,
        string $name,
        string $email,
        string $password,
        string $defaultCompanyId
    ): self {
        $user = new self($id, $name, $email, $password, $defaultCompanyId);

        $user->record(new UserCreatedDomainEvent(
            (string)$user->id(),
            $user->name(),
            $user->email(),
            $user->defaultCompanyId()
        ));

        return $user;
    }

    public static function fromPrimitives(array $primitives): self
    {
        return new self(
            (int)$primitives['id'],
            (string)$primitives['name'],
            (string)$primitives['email'],
            (string)($primitives['password'] ?? ''),
            (string)$primitives["defaultCompanyId"]
        );
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

    public function password(): string
    {
        return $this->password;
    }

    public function defaultCompanyId(): string
    {
        return $this->defaultCompanyId;
    }

    public function changeName(string $name): void
    {
        $this->name = $name;
    }

    public function toPrimitives(): array
    {
        return [
            'id' => $this->id(),
            'name' => $this->name(),
            'email' => $this->email(),
            'password' => $this->password(),
            'default_company_id' => $this->defaultCompanyId(),
        ];
    }
}
