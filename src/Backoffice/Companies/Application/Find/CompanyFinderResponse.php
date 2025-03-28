<?php

declare(strict_types=1);

namespace MedineTech\Backoffice\Companies\Application\Find;

final readonly class CompanyFinderResponse
{
    public function __construct(
        private readonly string $id,
        private readonly string $name
    )
    {
    }

    public function id(): string
    {
        return $this->id;
    }

    public function name(): string
    {
        return $this->name;
    }
}
