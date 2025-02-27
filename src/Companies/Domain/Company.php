<?php

declare(strict_types=1);

namespace MedineTech\Companies\Domain;

final class Company
{
    public function __construct(
        private readonly string $id,
        private readonly array $data
    )
    {
    }

    public static function create(
        string $id,
        array $data
    ): self
    {
        return new self(
            $id,
            $data
        );
    }

    public function fromPrimitives(array $row): self
    {
        return new self(
            (string)$row['id'],
            (array)$row['data']
        );
    }

    public function toPrimitives(): array
    {
        return [
            'id' => $this->id(),
            'data' => $this->data()
        ];
    }

    public function id(): string
    {
        return $this->id;
    }

    public function data(): array
    {
        return $this->data;
    }

}
