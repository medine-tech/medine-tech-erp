<?php

declare(strict_types=1);

namespace MedineTech\Backoffice\Security\RolePermissions\Domain;

use MedineTech\Shared\Domain\Aggregate\AggregateRoot;

final class RolePermission extends AggregateRoot
{
    public function __construct(
        private readonly int $roleId,
        private int $permissionId
    ) {
    }

    public static function create(
        int $roleId,
        int $permissionId
    ): self {
        return new self(
            $roleId,
            $permissionId
        );
    }

    public static function delete(
        int $roleId,
        int $permissionId
    ): self {
        return new self(
            $roleId,
            $permissionId
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
