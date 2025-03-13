<?php

declare(strict_types=1);

namespace MedineTech\Backoffice\Security\Roles\Application\Update;

class RoleUpdaterRequest
{
    public function __construct(
        private readonly int $id,
        private readonly string $name,
        private readonly ?string $description,
        private readonly ?string $status,
        private readonly int $updaterId,
        private readonly string $companyId
    )
    {
    }

    public function id(): int
    {
        return $this->id;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function description(): ?string
    {
        return $this->description;
    }

    public function status(): ?string
    {
        return $this->status;
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
