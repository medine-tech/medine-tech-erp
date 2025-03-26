<?php

declare(strict_types=1);

namespace MedineTech\Auth\Users\Application\Find;

final readonly class AuthUserFinderResponse
{
    public function __construct(
        private int $id,
        private string $name,
        private string $email,
        private string $defaultCompanyId
    ) {
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

    public function defaultCompanyId(): string
    {
        return $this->defaultCompanyId;
    }
}
