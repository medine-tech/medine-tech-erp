<?php

declare(strict_types=1);

namespace MedineTech\Backoffice\Security\Roles\Application\Find;

final readonly class RoleFinderRequest
{
    public function __construct(
        private int $id
    )
    {
    }

    public function id(): int
    {
        return $this->id;
    }
}
