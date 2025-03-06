<?php
declare(strict_types=1);

namespace MedineTech\Users\Domain;

final class User
{
    private bool $passwordChanged = false;

    public function __construct(
        private int $id,
        private string $name,
        private string $email,
        private string $password
    ) {}

    public static function create(
        int $id,
        string $name,
        UserEmail $email,
        string $password
    ): self {
        return new self($id, $name, $email->value(), $password);
    }

    public static function fromPrimitives(array $primitives): self
    {
        return new self(
            (int) $primitives['id'],
            (string) $primitives['name'],
            (string) $primitives['email'],
            (string) ($primitives['password'] ?? '')
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
        return $this->email;
    }

    public function password(): ?string
    {
        return $this->password;
    }

    public function isPasswordChanged(): bool
    {
        return $this->passwordChanged;
    }

    public function changeName(string $name): void
    {
        $this->name = $name;
    }

    public function changeEmail(UserEmail $email): void
    {
        if ($email->value() === $this->email) {
            return;
        }
        $this->email = $email->value();
    }

    public function changePassword(?string $password): void
    {
        if ($password === null) {
            return;
        }

        $this->password = $password;
        $this->passwordChanged = true;
    }

    public function toPrimitives(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'password' => $this->password
        ];
    }
}
