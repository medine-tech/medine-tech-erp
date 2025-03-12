<?php

declare(strict_types=1);

namespace MedineTech\Backoffice\Accounting\AccountingAccounts\Application\Find;

final readonly class AccountingAccountFinderResponse
{
    public function __construct(
        private readonly string $id,
        private readonly string $code,
        private readonly string $name,
        private readonly ?string $description,
        private readonly int $type,
        private readonly string $status,
        private readonly ?string $parentId,
        private readonly int $creatorId,
        private readonly int $updaterId,
        private readonly string $companyId
    )
    {
    }

    public function id(): string
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

    public function type(): int
    {
        return $this->type;
    }

    public function status(): string
    {
        return $this->status;
    }

    public function parentId(): ?string
    {
        return $this->parentId;
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
