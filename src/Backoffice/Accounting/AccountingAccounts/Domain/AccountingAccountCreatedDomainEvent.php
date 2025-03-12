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
        private readonly string $parentId,
        private readonly string $companyId,
        private readonly int $creatorId,
        private readonly int $updaterId,
        ?string $eventId = null,
        ?string $occurredOn = null
    ) {
        parent::__construct($aggregateId, $eventId, $occurredOn);
    }

    public static function fromPrimitives(
        string $aggregateId,
        array $body,
        string $eventId,
        string $occurredOn
    ): DomainEvent {
        return new self(
            $aggregateId,
            (string)$body['code'],
            (string)$body['name'],
            isset($body['description']) ? (string)$body['description'] : null,
            (int)$body['type'],
            (string)$body['status'],
            isset($body['parent_id']) ? (string)$body['parent_id'] : null,
            (string)$body['company_id'],
            (int)$body['creator_id'],
            (int)$body['updater_id'],
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
            'code' => $this->code,
            'name' => $this->name,
            'description' => $this->description,
            'type' => $this->type,
            'status' => $this->status,
            'parentId' => $this->parentId,
            'companyId' => $this->companyId,
            'creatorId' => $this->creatorId,
            'updaterId' => $this->updaterId
        ];
    }
}
