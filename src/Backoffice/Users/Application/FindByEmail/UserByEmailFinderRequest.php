<?php

declare(strict_types=1);

namespace MedineTech\Backoffice\Users\Application\FindByEmail;

final readonly class UserByEmailFinderRequest
{
    public function __construct(
        private string $email,
    ) {
    }

    public function email(): string
    {
        return $this->email;
    }
}
