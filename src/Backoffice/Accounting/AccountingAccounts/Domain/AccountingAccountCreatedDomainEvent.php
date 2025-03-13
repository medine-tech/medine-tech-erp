<?php

declare(strict_types=1);

namespace MedineTech\Backoffice\Accounting\AccountingAccounts\Domain;

use MedineTech\Shared\Domain\Bus\Event\DomainEvent;

final class AccountingAccountCreatedDomainEvent extends DomainEvent
{
    public function __construct(
        string $aggregateId,
        private readonly string $code,
        private readonly string $name,
        private readonly ?string $description,
        private readonly int $type,
        private readonly string $status,
        private readonly ?string $parentId,
        private readonly int $creatorId,
        private readonly int $updaterId,
        private readonly string $companyId,
        ?string $eventId = null,
        ?string $occurredOn = null
    )
    {
        parent::__construct($aggregateId, $eventId, $occurredOn);
    }

    public static function fromPrimitives(
        string $aggregateId,
        array $body,
        string $eventId,
        string $occurredOn
    ): DomainEvent
    {
        return new self(
            $aggregateId,
            (string)$body['code'],
            (string)$body['name'],
            (string)($body['description'] ?? null),
            (int)$body['type'],
            (string)$body['status'],
            (string)($body['parent_id'] ?? null),
            (int)$body['creator_id'],
            (int)$body['updater_id'],
            (string)$body['company_id'],
            $eventId,
            $occurredOn
        );
    }

    public static function eventName(): string
    {
        return "backoffice.accounting.accounting-accounts.created";
    }

    public function toPrimitives(): array
    {
        return [
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
