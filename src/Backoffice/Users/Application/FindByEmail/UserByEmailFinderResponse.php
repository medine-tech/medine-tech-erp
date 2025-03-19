<?php

declare(strict_types=1);

namespace MedineTech\Backoffice\Users\Application\FindByEmail;

final readonly class UserByEmailFinderResponse
{
    public function __construct(
        private int $id,
        private string $name,
        private string $email
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
}
