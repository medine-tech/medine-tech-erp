<?php

declare(strict_types=1);

namespace MedineTech\Backoffice\Security\UserRoles\Application\Detach;

use MedineTech\Backoffice\Security\UserRoles\Domain\UserRoleRepository;

final class DetachRoleOnUserCreated
{
    public function __construct(
        private readonly UserRoleRepository $repository
    ) {
    }

    public function __invoke(string $roleId, string $permissionId): void
    {
        $this->repository->detachPermission($roleId, $permissionId);
    }
}
