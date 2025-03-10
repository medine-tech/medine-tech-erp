<?php

declare(strict_types=1);

namespace MedineTech\Backoffice\CompanyUsers\Domain;

use MedineTech\Shared\Domain\Bus\Event\DomainEvent;

final class CompanyUserCreatedDomainEvent extends DomainEvent
{
    public function __construct(
        string $aggregateId,
        private readonly string $companyId,
        private readonly int $userId,
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
            (string)$body['companyId'],
            (int)$body['userId'],
            $eventId,
            $occurredOn
        );
    }

    public static function eventName(): string
    {
        return "backoffice.company_user.created";
    }

    public function toPrimitives(): array
    {
        return [
            'companyId' => $this->companyId(),
            'userId' => $this->userId(),
        ];
    }

    public function companyId(): string
    {
        return $this->companyId;
    }

    public function userId(): int
    {
        return $this->userId;
    }
}
