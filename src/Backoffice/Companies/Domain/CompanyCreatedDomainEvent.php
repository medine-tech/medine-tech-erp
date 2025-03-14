<?php

declare(strict_types=1);

namespace MedineTech\Backoffice\Companies\Domain;

use MedineTech\Shared\Domain\Bus\Event\DomainEvent;

final class CompanyCreatedDomainEvent extends DomainEvent
{
    public function __construct(
        string $aggregateId,
        private readonly string $name,
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
            $eventId,
            $occurredOn
        );
    }

    public static function eventName(): string
    {
        return "backoffice.company.created";
    }

    public function toPrimitives(): array
    {
        return [
            'name' => $this->name,
        ];
    }
}
