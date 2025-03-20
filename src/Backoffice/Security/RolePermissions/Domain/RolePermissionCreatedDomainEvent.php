<?php

declare(strict_types=1);

namespace MedineTech\Backoffice\Security\RolePermissions\Domain;

use MedineTech\Shared\Domain\Bus\Event\DomainEvent;

final class RolePermissionCreatedDomainEvent extends DomainEvent
{
    public function __construct(
        string $aggregateId,
        private readonly int $roleId,
        private readonly int $permissionId,
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
    ): DomainEvent
    {
        if (!isset($body['role_id']) || !isset($body['permission_id'])) {
            throw new InvalidArgumentException('Role ID and Permission ID are required');
        }
        
        return new self(
            $aggregateId,
            (int)$body['role_id'],
            (int)$body['permission_id'],
            $eventId,
            $occurredOn
        );
    }

    public static function eventName(): string
    {
        return "backoffice.security.role-permissions.create";
    }

    public function toPrimitives(): array
    {
        return [
            'role_id' => $this->roleId(),
            'permission_id' => $this->permissionId()
        ];
    }

    public function roleId(): int
    {
        return $this->roleId;
    }

    public function permissionId(): int
    {
        return $this->permissionId;
    }
}
