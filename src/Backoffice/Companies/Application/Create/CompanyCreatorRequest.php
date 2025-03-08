<?php

declare(strict_types=1);

namespace MedineTech\Backoffice\Companies\Application\Create;

final readonly class CompanyCreatorRequest
{
    public function __construct(
        private string $id,
        private string $name,
        private int $userId,
    ) {
    }

    public function name(): string
    {
        return $this->name;
    }

    public function id(): string
    {
        return $this->id;
    }

    public function userId(): int
    {
        return $this->userId;
    }
}
