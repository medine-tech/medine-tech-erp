<?php

declare(strict_types=1);

namespace MedineTech\Auth\Companies\Domain;

use MedineTech\Shared\Domain\Aggregate\AggregateRoot;

final class AuthCompany extends AggregateRoot
{
    public function __construct(
        private readonly string $id,
        private string $name
    ) {
    }

    public static function create(
        string $id,
        string $name
    ): self {
        $company = new self(
            $id,
            $name
        );

        return $company;
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
