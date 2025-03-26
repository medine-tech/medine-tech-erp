<?php

declare(strict_types=1);

namespace MedineTech\Auth\Users\Application\Find;

final readonly class AuthUserFinderRequest
{
    public function __construct(
        private readonly int $id
    ) {
    }

    public function id(): int
    {
        return $this->id;
    }
}
