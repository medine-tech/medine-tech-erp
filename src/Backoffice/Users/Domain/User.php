<?php
declare(strict_types=1);

namespace MedineTech\Backoffice\Users\Domain;

use MedineTech\Shared\Domain\Aggregate\AggregateRoot;

final class User extends AggregateRoot
{
    private UserEmail $email;

    public function __construct(
        private int $id,
        private string $name,
        string $email,
        private ?string $password
    ) {
        $this->email = new UserEmail($email);
    }

    public static function create(
        int $id,
        string $name,
        string $email,
        ?string $password
    ): self {
        $user = new self($id, $name, $email, $password);

        $user->record(new UserCreatedDomainEvent(
            (string)$user->id(),
            $user->name(),
            $user->email()
        ));

        return $user;
    }

    public static function fromPrimitives(array $primitives): self
    {
        return new self(
            (int)$primitives['id'],
            (string)$primitives['name'],
            (string)$primitives['email'],
            (string)($primitives['password'] ?? '')
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

    public function password(): ?string
    {
        return $this->password;
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
        ];
    }
}
