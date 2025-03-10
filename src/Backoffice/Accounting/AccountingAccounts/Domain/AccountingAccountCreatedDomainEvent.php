<?php

declare(strict_types=1);

namespace MedineTech\Backoffice\Accounting\AccountingAccounts\Domain;

use MedineTech\Shared\Domain\Bus\Event\DomainEvent;

final class AccountingAccountCreatedDomainEvent extends DomainEvent
{
    public function __construct(
        string $aggregateId,
        private readonly string $name,
        private readonly string $code,
        private readonly int $type,
        private readonly string $parentId,
        private readonly int $status,
        private readonly string $companyId,
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
            (string)$body['name'],
            (string)$body['code'],
            (int)$body['type'],
            (string)$body['parent_id'],
            (int)$body['status'],
            (string)$body['company_id'],
            $eventId,
            $occurredOn
        );
    }

    public static function eventName(): string
    {
        return "backoffice.accounting_account.created";
    }

    public function toPrimitives(): array
    {
        return [
            'name' => $this->name,
            'code' => $this->code,
            'type' => $this->type,
            'parent_id' => $this->parentId,
            'status' => $this->status,
            'company_id' => $this->companyId
        ];
    }
}
