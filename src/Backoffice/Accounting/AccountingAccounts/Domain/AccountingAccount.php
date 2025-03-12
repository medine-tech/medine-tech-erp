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
        private string $companyId,
        private int $creatorId,
        private int $updaterId
    ) {
    }

    public static function create(
        string $id,
        string $code,
        string $name,
        ?string $description,
        int $type,
        ?string $parentId,
        string $companyId,
        int $creatorId,
        int $updaterId
    ): self {

        $status = AccountingAccountStatus::ACTIVE;

        $accountingAccount = new self(
            $id,
            $code,
            $name,
            $description,
            $type,
            $status,
            $parentId,
            $companyId,
            $creatorId,
            $updaterId
        );

        $accountingAccount->record(new AccountingAccountCreatedDomainEvent(
            $accountingAccount->id(),
            $accountingAccount->code(),
            $accountingAccount->name(),
            $accountingAccount->description(),
            $accountingAccount->type(),
            $accountingAccount->status(),
            $accountingAccount->parentId(),
            $accountingAccount->companyId(),
            $accountingAccount->creatorId(),
            $accountingAccount->updaterId()
        ));

        return $accountingAccount;
    }

    public static function fromPrimitives(array $row): self
    {

        return new self(
            (string)$row['id'],
            (string)$row['code'],
            (string)$row['name'],
            isset($row['description']) ? (string)$row['description'] : null,
            (int)$row['type'],
            (string)$row['status'],
            isset($row['parent_id']) ? (string)$row['parent_id'] : null,
            (string)$row['company_id'],
            (int)$row['creator_id'],
            (int)$row['updater_id']
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
            'companyId' => $this->companyId(),
            'creatorId' => $this->creatorId(),
            'updaterId' => $this->updaterId()
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

    public function companyId(): string
    {
        return $this->companyId;
    }

    public function creatorId(): int
    {
        return $this->creatorId;
    }

    public function updaterId(): int
    {
        return $this->updaterId;
    }
}
