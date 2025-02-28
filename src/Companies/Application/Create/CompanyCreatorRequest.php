<?php

declare(strict_types=1);

namespace MedineTech\Companies\Application\Create;

use MedineTech\Companies\Domain\Company;

final class CompanyCreatorRequest
{
    public function __construct(
        private readonly string $id,
        private readonly string $name
    )
    {
    }

    public function name(): string
    {
        return $this->name;
    }

    public function id(): string
    {
        return $this->id;
    }
}
