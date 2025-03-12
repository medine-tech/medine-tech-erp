<?php

declare(strict_types=1);

namespace MedineTech\Backoffice\Accounting\AccountingAccounts\Domain;

use MedineTech\Shared\Domain\Aggregate\AggregateRoot;

final class AccountingAccount extends AggregateRoot
{
    public function __construct(
        private readonly string $id,
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

    public static function create(
        string $id,
        string $code,
        string $name,
        ?string $description,
        int $type,
        ?string $parentId,
        int $creatorId,
        string $companyId
    ): self {

        $status = AccountingAccountStatus::ACTIVE;
        $updaterId = $creatorId;

        $accountingAccount = new self(
            $id,
            $code,
            $name,
            $description,
            $type,
            $status,
            $parentId,
            $creatorId,
            $updaterId,
            $companyId
        );

        $accountingAccount->record(new AccountingAccountCreatedDomainEvent(
            $accountingAccount->id(),
            $accountingAccount->code(),
            $accountingAccount->name(),
            $accountingAccount->description(),
            $accountingAccount->type(),
            $accountingAccount->status(),
            $accountingAccount->parentId(),
            $accountingAccount->creatorId(),
            $accountingAccount->updaterId(),
            $accountingAccount->companyId()
        ));

        return $accountingAccount;
    }

    public static function fromPrimitives(array $row): self
    {

        return new self(
            (string)$row['id'],
            (string)$row['code'],
            (string)$row['name'],
            (string)($row['description'] ?? null),
            (int)$row['type'],
            (string)$row['status'],
            (string)($row['parent_id'] ?? null),
            (int)$row['creator_id'],
            (int)$row['updater_id'],
            (string)$row['company_id']
        );
    }

    public function toPrimitives(): array
    {
        return [
            'id' => $this->id(),
            'code' => $this->code(),
            'name' => $this->name(),
            'description' => $this->description(),
            'type' => $this->type(),
            'status' => $this->status(),
            'parentId' => $this->parentId(),
            'creatorId' => $this->creatorId(),
            'updaterId' => $this->updaterId(),
            'companyId' => $this->companyId()
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

    public function changeName(string $name): void
    {
        if ($name === $this->name()) {
            return;
        }

        $this->name = $name;
    }

    public function changeDescription(?string $description): void
    {
        if ($description === $this->description()) {
            return;
        }

        $this->description = $description;
    }

    public function changeType(int $type): void
    {
        if ($type === $this->type()) {
            return;
        }

        $this->type = $type;
    }

    public function changeStatus(string $status): void
    {
        if ($status === $this->status()) {
            return;
        }

        $this->status = $status;
    }

    public function changeUpdaterId(int $updaterId): void
    {
        if ($updaterId === $this->updaterId()) {
            return;
        }

        $this->updaterId = $updaterId;
    }

    public function changeParentId(?string $parentId): void
    {
        if ($parentId === $this->parentId()) {
            return;
        }

        $this->parentId = $parentId;
    }
}
