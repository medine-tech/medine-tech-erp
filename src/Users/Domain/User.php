<?php

declare(strict_types=1);

namespace MedineTech\Users\Domain;

final class User
{

    public function __construct(
      private readonly string $name,
      private readonly string $email,
      private readonly string $password
    ) {
    }

    public static function create(
        string $name,
        string $email,
        string $password
    ): self {

        return new self(
            $name,
            $email,
            $password,
        );
    }

    public static function fromPrimitive(array $params): self
    {
        return new self(
            $params['name'],
            $params['email'],
            $params['password'],
        );
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
            'name'     => $this->name(),
            'password' => $this->password(),
        ];
    }
}
