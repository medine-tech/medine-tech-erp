<?php

declare(strict_types=1);

namespace MedineTech\Backoffice\Security\RolePermissions\Application\Delete;

use MedineTech\Backoffice\Security\RolePermissions\Domain\RolePermission;
use MedineTech\Backoffice\Security\RolePermissions\Domain\RolePermissionRepository;

final class RolePermissionDeleter
{
    public function __construct(
        private readonly RolePermissionRepository $repository
    ) {
    }

    public function __invoke(RolePermissionDeleterRequest $request): void
    {
        $rolePermission = RolePermission::find(
            $request->roleId(),
            $request->permissionId()
        );

        $this->repository->delete($rolePermission);
    }
}
