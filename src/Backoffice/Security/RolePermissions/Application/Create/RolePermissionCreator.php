<?php

declare(strict_types=1);

namespace MedineTech\Backoffice\Security\RolePermissions\Application\Create;

use MedineTech\Backoffice\Security\RolePermissions\Domain\RolePermission;
use MedineTech\Backoffice\Security\RolePermissions\Domain\RolePermissionRepository;

final class RolePermissionCreator
{
    public function __construct(
        private readonly RolePermissionRepository $repository
    ) {
    }

    public function __invoke(RolePermissionCreatorRequest $request): void
    {
        $rolePermission = RolePermission::create(
            $request->roleId(),
            $request->permissionId()
        );

        $this->repository->save($rolePermission);
    }
}
