<?php

declare(strict_types=1);

namespace MedineTech\Backoffice\Users\Application\Find;

final class UserFinderRequest
{
    public function __construct(
        private int $id
    ) {}

    public function id(): int
    {
        return $this->id;
    }
}
