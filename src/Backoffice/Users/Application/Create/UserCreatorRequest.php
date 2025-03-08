<?php

declare(strict_types=1);

namespace MedineTech\Backoffice\Users\Application\Create;

final readonly class UserCreatorRequest
{
    public function __construct(
        private string $name,
        private string $email,
        private string $password,
        private string $companyId,
    ) {
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

    public function companyId(): string
    {
        return $this->companyId;
    }
}
