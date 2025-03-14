<?php

declare(strict_types=1);

namespace MedineTech\Backoffice\Accounting\AccountingAccounts\Application\Update;

class AccountingAccountUpdaterRequest
{
    public function __construct(
        private readonly string $id,
        private readonly string $name,
        private readonly ?string $description,
        private readonly int $type,
        private readonly string $status,
        private readonly int $updaterId,
        private readonly ?string $parentId,
    )
    {
    }

    public function id(): string
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

    public function type(): int
    {
        return $this->type;
    }

    public function status(): string
    {
        return $this->status;
    }

    public function updaterId(): int
    {
        return $this->updaterId;
    }

    public function parentId(): ?string
    {
        return $this->parentId;
    }
}
