<?php

declare(strict_types=1);

namespace MedineTech\Auth\Companies\Domain;

use MedineTech\Shared\Domain\Bus\Event\DomainEvent;

final class AuthCompanyCreatedDomainEvent extends DomainEvent
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
        return 'auth.company.create';
    }

    public function toPrimitives(): array
    {
        return [
            'name' => $this->name,
        ];
    }
}
