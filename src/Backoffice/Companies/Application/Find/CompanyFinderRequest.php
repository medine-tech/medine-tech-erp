<?php

declare(strict_types=1);

namespace MedineTech\Backoffice\Companies\Application\Find;

final readonly class CompanyFinderRequest
{
    public function __construct(
        private readonly string $id
    )
    {
    }

    public function id(): string
    {
        return $this->id;
    }
}
