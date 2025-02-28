<?php

declare(strict_types=1);

namespace MedineTech\Companies\Domain;

final class Company
{
    public function __construct(
        private readonly string $id,
        private readonly string $name
    )
    {
    }

    public static function create(
        string $id,
        string $name
    ): self
    {
        return new self(
            $id,
            $name
        );
    }

    public static function fromPrimitives(array $row): self
    {
        return new self(
            (string)$row['id'],
            (string)$row['name']
        );
    }

    public function toPrimitives(): array
    {
        return [
            'id' => $this->id(),
            'name' => $this->name()
        ];
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
