<?php

declare(strict_types=1);

namespace MedineTech\Backoffice\Security\RolePermissions\Domain;

use MedineTech\Shared\Domain\DomainException;

final class RolePermissionNotFoundException extends DomainException
{
    public function __construct(
        public readonly int $roleId,
        public readonly int $permissionId
    ) {
        parent::__construct();
    }

    public function errorCode(): string
    {
        return 'role_permission_not_found';
    }

    public function errorMessage(): string
    {
        return "Role Permission not found";
    }
}
