<?php

declare(strict_types=1);

namespace MedineTech\Backoffice\Security\Roles\Domain;

use MedineTech\Shared\Domain\Bus\Event\DomainEvent;

final class RoleCreatedDomainEvent extends DomainEvent
{
    public function __construct(
        string $aggregateId,
        private readonly string $code,
        private readonly string $name,
        private readonly string $description,
        private readonly string $status,
        private readonly int $creatorId,
        private readonly int $updaterId,
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
            (string)$body['code'],
            (string)$body['name'],
            (string)$body['description'],
            (string)$body['status'],
            (int)$body['creatorId'],
            (int)$body['updaterId'],
            (string)$body['companyId'],
            $eventId,
            $occurredOn
        );
    }

    public static function eventName(): string
    {
        return "backoffice.security.role.create";
    }

    public function toPrimitives(): array
    {
        return [
            'code' => $this->code,
            'name' => $this->name,
            'description' => $this->description,
            'status' => $this->status,
            'creatorId' => $this->creatorId,
            'updaterId' => $this->updaterId,
            'companyId' => $this->companyId,
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

    public function description(): string
    {
        return $this->description;
    }

    public function status(): string
    {
        return $this->status;
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
