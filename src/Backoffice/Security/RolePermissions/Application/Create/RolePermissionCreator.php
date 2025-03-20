<?php

declare(strict_types=1);

namespace MedineTech\Backoffice\Security\RolePermissions\Application\Create;

use MedineTech\Backoffice\Security\RolePermissions\Domain\RolePermission;
use MedineTech\Backoffice\Security\RolePermissions\Domain\RolePermissionRepository;
use MedineTech\Shared\Domain\Bus\Event\EventBus;

final class RolePermissionCreator
{
    public function __construct(
        private readonly RolePermissionRepository $repository,
        private readonly EventBus $eventBus
    ) {
    }

    public function __invoke(RolePermissionCreatorRequest $request): void
    {
        $rolePermission = RolePermission::create(
            $request->roleId(),
            $request->permissionId()
        );

        $this->repository->save($rolePermission);
        $this->eventBus->publish(...$rolePermission->pullDomainEvents());
    }
}
