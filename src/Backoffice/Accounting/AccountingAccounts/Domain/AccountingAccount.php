<?php

declare(strict_types=1);

namespace MedineTech\Backoffice\Accounting\AccountingAccounts\Domain;

use MedineTech\Shared\Domain\Aggregate\AggregateRoot;

final class AccountingAccount extends AggregateRoot
{
    public function __construct(
        private readonly string $id,
        private string $name,
        private string $code,
        private int $type,
        private string $parentId,
        private int $status,
        private string $companyId
    ) {
    }

    public static function create(
        string $id,
        string $name,
        string $code,
        int $type,
        string $parentId,
        int $status,
        string $companyId
    ): self {
        $accountingAccount = new self(
            $id,
            $name,
            $code,
            $type,
            $parentId,
            $status,
            $companyId
        );

        $accountingAccount->record(new AccountingAccountCreatedDomainEvent(
            $accountingAccount->id(),
            $accountingAccount->name(),
            $accountingAccount->code(),
            $accountingAccount->type(),
            $accountingAccount->parentId(),
            $accountingAccount->status(),
            $accountingAccount->companyId()
        ));

        return $accountingAccount;
    }

    public static function fromPrimitives(array $row): self
    {
        return new self(
            (string)$row['id'],
            (string)$row['name'],
            (string)$row['code'],
            (int)$row['type'],
            (string)$row['parent_id'],
            (int)$row['status'],
            (string)$row['company_id']
        );
    }

    public function toPrimitives(): array
    {
        return [
            'id' => $this->id(),
            'name' => $this->name(),
            'code' => $this->code(),
            'type' => $this->type(),
            'parent_id' => $this->parentId(),
            'status' => $this->status(),
            'company_id' => $this->companyId()
        ];
    }

    public function id(): string
    {
        return $this->id;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function code(): string
    {
        return $this->code;
    }

    public function type(): int
    {
        return $this->type;
    }

    public function parentId(): string
    {
        return $this->parentId;
    }

    public function status(): int
    {
        return $this->status;
    }

    public function companyId(): string
    {
        return $this->companyId;
    }
}
