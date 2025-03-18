<?php

declare(strict_types=1);

namespace MedineTech\Backoffice\Security\RolePermissions\Domain;

use DomainException;

final class RolePermissionNotFoundException extends DomainException
{
    public function __construct(string $roleId, string $permissionId)
    {
        parent::__construct("The role with id <$roleId> does not have the permission with id <$permissionId>.");
    }
}
