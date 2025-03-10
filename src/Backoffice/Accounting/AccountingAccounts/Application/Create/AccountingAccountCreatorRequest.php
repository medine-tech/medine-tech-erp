<?php

declare(strict_types=1);

namespace MedineTech\Backoffice\Accounting\AccountingAccounts\Application\Create;

final readonly class AccountingAccountCreatorRequest
{
    public function __construct(
        private string $id,
        private string $name,
        private string $code,
        private int $type,
        private ?string $parentId,
        private int $status,
        private string $companyId
    ) {
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

    public function parentId(): ?string
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
