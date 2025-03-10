<?php

declare(strict_types=1);

namespace MedineTech\Backoffice\Accounting\AccountingCenter\Domain;

use MedineTech\Shared\Domain\Bus\Event\DomainEvent;

final class AccountingCenterCreatedDomainEvent extends DomainEvent
{
    public function __construct(
        string $aggregateId,
        private readonly string $code,
        private readonly string $name,
        private readonly ?string $description,
        private readonly int $status,
        private readonly ?string $parentId,
        private readonly string $companyId,
        private readonly string $createdBy,
        private readonly string $updatedBy,
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
            (int)$body['status'],
            isset($body['parent_id']) ? (string)$body['parent_id'] : null,
            (string)$body['company_id'],
            (string)$body['created_by'],
            (string)$body['updated_by'],
            $eventId,
            $occurredOn
        );
    }

    public static function eventName(): string
    {
        return "backoffice.accounting_center.created";
    }

    public function toPrimitives(): array
    {
        return [
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
}
