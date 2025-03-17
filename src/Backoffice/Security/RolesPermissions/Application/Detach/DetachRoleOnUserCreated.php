<?php

declare(strict_types=1);

namespace MedineTech\Backoffice\Security\RolesPermissions\Application\Detach;

use MedineTech\Backoffice\Security\RolesPermissions\Domain\UserRoleRepository;

final class DetachRoleOnUserCreated
{
    public function __construct(
        private readonly UserRoleRepository $repository
    ) {
    }

    public function __invoke(int $roleId, string $permissionId): void
    {
        $this->repository->detachPermission($roleId, $permissionId);
    }
}
