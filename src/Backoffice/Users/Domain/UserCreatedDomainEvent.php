<?php

declare(strict_types=1);

namespace MedineTech\Backoffice\Users\Domain;

use MedineTech\Shared\Domain\Bus\Event\DomainEvent;

final class UserCreatedDomainEvent extends DomainEvent
{
    public function __construct(
        string $aggregateId,
        private readonly string $name,
        private readonly string $email,
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
            (string)$body['email'],
            $eventId,
            $occurredOn
        );
    }

    public static function eventName(): string
    {
        return "backoffice.user.created";
    }

    public function toPrimitives(): array
    {
        return [
            'name' => $this->name,
            'email' => $this->email,
        ];
    }

    public function name(): string
    {
        return $this->name;
    }

    public function email(): string
    {
        return $this->email;
    }
}
