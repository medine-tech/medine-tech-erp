<?php

declare(strict_types=1);

namespace MedineTech\Auth\Companies\Domain;

use MedineTech\Shared\Domain\Aggregate\AggregateRoot;

final class AuthCompany extends AggregateRoot
{
    public function __construct(
        private readonly string $id,
        private readonly string $name
    ) {
    }

    public function id(): string
    {
        return $this->id;
    }

    public function name(): string
    {
        return $this->name;
    }

    /**
     * @param array<string, mixed> $row
     */
    public static function fromPrimitives(array $row): self
    {
        return new self(
            (string)$row['id'],
            (string)$row['name']
        );
    }
}
