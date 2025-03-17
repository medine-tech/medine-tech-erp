<?php

declare(strict_types=1);

namespace MedineTech\Backoffice\Security\RolesPermissions\Domain;

interface UserRoleRepository
{
    public function attachPermission(int $roleId, string $permissionId): void;

    public function detachPermission(int $roleId, string $permissionId): void;
}
