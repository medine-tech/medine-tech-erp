<?php

declare(strict_types=1);

namespace MedineTech\Backoffice\Security\Roles\Application\Create;

final readonly class RoleCreatorRequest
{
    public function __construct(
        private int $id,
        private string $name,
        private string $description,
        private int $creatorId,
        private string $companyId
    ) {
    }

    public function id(): int
    {
        return $this->id;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function description(): string
    {
        return $this->description;
    }

    public function creatorId(): int
    {
        return $this->creatorId;
    }

    public function companyId(): string
    {
        return $this->companyId;
    }
}
