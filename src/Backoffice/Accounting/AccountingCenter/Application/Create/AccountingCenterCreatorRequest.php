<?php

declare(strict_types=1);

namespace MedineTech\Backoffice\Accounting\AccountingCenter\Application\Create;

final readonly class AccountingCenterCreatorRequest
{
    public function __construct(
        private string $id,
        private string $code,
        private string $name,
        private ?string $description,
        private int $status,
        private ?string $parentId,
        private string $companyId,
        private string $createdBy,
        private string $updatedBy
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

    public function status(): int
    {
        return $this->status;
    }

    public function parentId(): ?string
    {
        return $this->parentId;
    }

    public function companyId(): string
    {
        return $this->companyId;
    }

    public function createdBy(): string
    {
        return $this->createdBy;
    }

    public function updatedBy(): string
    {
        return $this->updatedBy;
    }
}
