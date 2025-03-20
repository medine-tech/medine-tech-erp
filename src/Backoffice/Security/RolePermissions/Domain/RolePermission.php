<?php

declare(strict_types=1);

namespace MedineTech\Backoffice\Security\RolePermissions\Domain;

use MedineTech\Shared\Domain\Aggregate\AggregateRoot;

final class RolePermission extends AggregateRoot
{
    public function __construct(
        private readonly int $roleId,
        private readonly int $permissionId
    ) {
    }

    public static function create(
        int $roleId,
        int $permissionId
    ): self
    {

        $rolePermission = new self(
            $roleId,
            $permissionId
        );

        $rolePermission->record(new RolePermissionCreatedDomainEvent(
            (string)$rolePermission->roleId(),
            $rolePermission->roleId(),
            $rolePermission->permissionId()
        ));

        return $rolePermission;
    }

    public static function fromPrimitives(array $primitives): self
    {
        return new self(
            (int)$primitives['roleId'],
            (int)$primitives['permissionId']
        );
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
