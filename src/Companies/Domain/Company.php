<?php

declare(strict_types=1);

namespace MedineTech\Companies\Domain;

final class Company
{
    public function __construct(
        private readonly string $name
    )
    {
    }

    public static function create(
        string $name
    ): self
    {
        return new self(
            $name
        );
    }

    public function fromPrimitives(array $row): self
    {
        return new self(
            (string)$row['name']
        );
    }

    public function toPrimitives(): array
    {
        return [
            'name' => $this->name()
        ];
    }

    public function name(): string
    {
        return $this->name;
    }

}
