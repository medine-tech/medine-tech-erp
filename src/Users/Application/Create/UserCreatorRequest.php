<?php

declare(strict_types=1);

namespace MedineTech\Users\Application\Create;

final class UserCreatorRequest
{
    private string $name;
    private string $email;
    private string $password;

    public function __construct(array $data)
    {
        $this->name = $data['name'] ?? '';
        $this->email = $data['email'] ?? '';
        $this->password = $data['password'] ?? '';
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
}
