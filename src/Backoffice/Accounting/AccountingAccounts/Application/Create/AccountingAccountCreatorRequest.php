<?php

declare(strict_types=1);

namespace MedineTech\Backoffice\Accounting\AccountingAccounts\Application\Create;

final readonly class AccountingAccountCreatorRequest
{
    public function __construct(
        private string $id,
        private string $code,
        private string $name,
        private ?string $description,
        private int $type,
        private ?string $parentId,
        private int $creatorId,
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

    public function parentId(): ?string
    {
        return $this->parentId;
    }

    public function creatorId(): int
    {
        return $this->creatorId;
    }

    public function companyId(): string
    {
        return $this->companyId;
    }
}
