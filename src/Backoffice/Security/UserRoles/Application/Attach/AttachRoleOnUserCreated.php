<?php

declare(strict_types=1);

namespace MedineTech\Backoffice\Security\UserRoles\Application\Attach;

use MedineTech\Backoffice\Security\UserRoles\Domain\UserRoleRepository;

final class AttachRoleOnUserCreated
{
    public function __construct(
        private readonly UserRoleRepository $repository
    ) {
    }

    public function __invoke(string $roleId, string $permissionId): void
    {
        $this->repository->attachPermission($roleId, $permissionId);
    }
}
