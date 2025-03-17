<?php

declare(strict_types=1);

namespace MedineTech\Backoffice\Security\RolesPermissions\Application\Attach;

use MedineTech\Backoffice\Security\RolesPermissions\Domain\UserRoleRepository;

final class AttachRoleOnUserCreated
{
    public function __construct(
        private readonly UserRoleRepository $repository
    ) {
    }

    public function __invoke(int $roleId, string $permissionId): void
    {
        $this->repository->attachPermission($roleId, $permissionId);
    }
}
