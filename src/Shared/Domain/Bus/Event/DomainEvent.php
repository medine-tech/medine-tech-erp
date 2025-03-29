<?php

declare(strict_types=1);

namespace MedineTech\Shared\Domain\Bus\Event;

use DateTimeImmutable;
use MedineTech\Shared\Domain\Utils;
use MedineTech\Shared\Domain\ValueObject\Uuid;

abstract class DomainEvent
{
    private readonly string $eventId;
    private readonly string $occurredOn;

    public function __construct(private readonly string $aggregateId, ?string $eventId = null, ?string $occurredOn = null)
    {
        $this->eventId = $eventId ?: Uuid::random()->value();
        $this->occurredOn = $occurredOn ?: Utils::dateToString(new DateTimeImmutable());
    }

    /**
     * @param string $aggregateId
     * @param array<string, mixed> $body
     * @param string $eventId
     * @param string $occurredOn
     * @return static
     */
    abstract public static function fromPrimitives(
        string $aggregateId,
        array $body,
        string $eventId,
        string $occurredOn
    ): self;

    abstract public static function eventName(): string;

    /**
     * @return array<string, mixed>
     */
    abstract public function toPrimitives(): array;

    public function aggregateId(): string
    {
        return $this->aggregateId;
    }

    public function eventId(): string
    {
        return $this->eventId;
    }

    public function occurredOn(): string
    {
        return $this->occurredOn;
    }
}
