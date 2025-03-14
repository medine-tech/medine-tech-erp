<?php

declare(strict_types=1);

namespace MedineTech\Backoffice\Accounting\AccountingAccounts\Application\Search;

final readonly class AccountingAccountSearcherResponse
{
    public function __construct(
        private string $id,
        private string $code,
        private string $name,
        private ?string $description,
        private int $type,
        private string $status,
        private ?string $parentId,
        private int $creatorId,
        private int $updaterId,
        private string $companyId
    ) {
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
