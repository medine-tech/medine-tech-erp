<?php

declare(strict_types=1);

namespace MedineTech\Backoffice\Accounting\AccountingCenter\Domain;

use MedineTech\Shared\Domain\Aggregate\AggregateRoot;

final class AccountingCenter extends AggregateRoot
{
    public function __construct(
        private readonly string $id,
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

    public static function create(
        string $id,
        string $code,
        string $name,
        ?string $description,
        int $status,
        ?string $parentId,
        string $companyId,
        string $createdBy,
        string $updatedBy
    ): self {
        $accountingCenter = new self(
            $id,
            $code,
            $name,
            $description,
            $status,
            $parentId,
            $companyId,
            $createdBy,
            $updatedBy
        );

        $accountingCenter->record(new AccountingCenterCreatedDomainEvent(
            $accountingCenter->id(),
            $accountingCenter->code(),
            $accountingCenter->name(),
            $accountingCenter->description(),
            $accountingCenter->status(),
            $accountingCenter->parentId(),
            $accountingCenter->companyId(),
            $accountingCenter->createdBy(),
            $accountingCenter->updatedBy()
        ));

        return $accountingCenter;
    }

    public static function fromPrimitives(array $row): self
    {
        return new self(
            (string)$row['id'],
            (string)$row['code'],
            (string)$row['name'],
            isset($row['description']) ? (string)$row['description'] : null,
            (int)$row['status'],
            isset($row['parent_id']) ? (string)$row['parent_id'] : null,
            (string)$row['company_id'],
            (string)$row['created_by'],
            (string)$row['updated_by']
        );
    }

    public function toPrimitives(): array
    {
        return [
            'id' => $this->id,
            'code' => $this->code,
            'name' => $this->name,
            'description' => $this->description,
            'status' => $this->status,
            'parent_id' => $this->parentId,
            'company_id' => $this->companyId,
            'created_by' => $this->createdBy,
            'updated_by' => $this->updatedBy
        ];
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
