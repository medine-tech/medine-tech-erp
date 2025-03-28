<?php

declare(strict_types=1);

namespace MedineTech\Backoffice\Security\RolePermissions\Application\Delete;

final readonly class RolePermissionDeleterRequest
{
    public function __construct(
        private int $roleId,
        private int $permissionId,
    )
    {
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
