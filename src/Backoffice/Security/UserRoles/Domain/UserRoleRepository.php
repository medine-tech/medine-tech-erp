<?php

declare(strict_types=1);

namespace MedineTech\Backoffice\Security\UserRoles\Domain;

interface UserRoleRepository
{
    public function attachPermission(string $roleId, string $permissionId): void;

    public function detachPermission(string $roleId, string $permissionId): void;
}
