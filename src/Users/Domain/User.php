<?php

declare(strict_types=1);

namespace MedineTech\Users\Domain;

final class User
{

    private ?int $id;

    public function __construct(
      ?int $id,
      private readonly string $name,
      private readonly string $email,
      private readonly string $password
    ) {
        $this->id = $id;
    }

    public static function create(
        string $name,
        string $email,
        string $password
    ): self {

        return new self(
            null,
            $name,
            $email,
            $password,
        );
    }

    public static function fromPrimitive(array $params): self
    {
        return new self(
            $params['id'] ?? null,
            $params['name'],
            $params['email'],
            $params['password'],
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

    public function password(): string
    {
        return $this->password;
    }

    public function toPrimitive(): array
    {
        return [
            'id'       => $this->id(),
            'name'     => $this->name(),
            'email'    => $this->email(),
            'password' => $this->password(),
        ];
    }
}
