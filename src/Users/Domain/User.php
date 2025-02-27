<?php

declare(strict_types=1);

namespace MedineTech\Users\Domain;

final class User
{
    private string $id;
    private string $name;
    private string $email;
    private string $password;

    public function __construct(
        string $id,
        string $name,
        string $email,
        string $password,
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
    }

    public static function create(
        string $id,
        string $name,
        string $email,
        string $password
    ): self {

        return new self(
            $id,
            $name,
            $email,
            $password,
        );
    }

    public static function fromPrimitive(array $params): self
    {
        return new self(
            $params['id'],
            $params['name'],
            $params['email'],
            $params['password'],
        );
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
        return $this->email;
    }

    public function password(): string
    {
        return $this->password;
    }

    public function toPrimitive(): array
    {
        return [
            'id'       => $this->id(),
            'name'     => $this->name(),
            'password' => $this->password(),
        ];
    }

    public function changeName(string $newName): void
    {
        $this->name = $newName;
    }

    public function changeEmail(string $newEmail): void
    {
        $this->email = $newEmail;
    }

    public function changePassword(string $newPassword): void
    {
        $this->password = $newPassword;
    }
}
