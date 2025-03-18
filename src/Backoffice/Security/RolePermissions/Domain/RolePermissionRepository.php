<?php

declare(strict_types=1);

namespace MedineTech\Backoffice\Security\RolePermissions\Domain;

interface RolePermissionRepository
{
    public function save(RolePermission $rolePermission): void;

    public function delete(RolePermission $rolePermission): void;
}
