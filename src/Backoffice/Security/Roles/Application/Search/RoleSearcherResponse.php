<?php

namespace MedineTech\Backoffice\Security\Roles\Application\Search;

final readonly class RoleSearcherResponse
{
    public function __construct(
        private readonly int $id,
        private readonly string $code,
        private readonly string $name,
        private readonly ?string $description,
        private readonly string $status,
        private readonly int $creatorId,
        private readonly int $updaterId,
        private readonly string $companyId
    )
    {
    }

    public function id(): int
    {
        return $this->id;
    }

    public function code(): string
    {
        return $this->code;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function description(): ?string
    {
        return $this->description;
    }

    public function status(): string
    {
        return $this->status;
    }

    public function creatorId(): int
    {
        return $this->creatorId;
    }

    public function updaterId(): int
    {
        return $this->updaterId;
    }

    public function companyId(): string
    {
        return $this->companyId;
    }
}
