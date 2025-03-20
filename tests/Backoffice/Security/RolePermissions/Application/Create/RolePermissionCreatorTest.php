<?php

declare(strict_types=1);

namespace Tests\Backoffice\Security\RolePermissions\Application\Create;

use MedineTech\Backoffice\Security\RolePermissions\Application\Create\RolePermissionCreator;
use MedineTech\Backoffice\Security\RolePermissions\Application\Create\RolePermissionCreatorRequest;
use MedineTech\Backoffice\Security\RolePermissions\Domain\RolePermissionCreatedDomainEvent;
use MedineTech\Backoffice\Security\RolePermissions\Domain\RolePermissionRepository;
use PHPUnit\Framework\Attributes\Test;
use Tests\Backoffice\Security\RolePermissions\Domain\RolePermissionMother;
use Tests\Shared\Infrastructure\PhpUnit\UnitTestCase;

final class RolePermissionCreatorTest extends UnitTestCase
{
    #[Test]
    public function it_should_create_role_permission(): void
    {
        $rolePermission = RolePermissionMother::create();

        $rolePermissionRepository = $this->mock(RolePermissionRepository::class);

        $rolePermissionRepository->shouldReceive('save')
            ->once()
            ->with($this->similarTo($rolePermission))
            ->andReturnNull();

        $eventBus = $this->eventBus();

        $domainEvent = new RolePermissionCreatedDomainEvent(
            (string)$rolePermission->roleId(),
            $rolePermission->roleId(),
            $rolePermission->permissionId()
        );

        $this->shouldPublishDomainEvent($domainEvent);

        /** @var RolePermissionRepository $rolePermissionRepository */
        $creator = new RolePermissionCreator(
            $rolePermissionRepository,
            $eventBus
        );

        ($creator)(new RolePermissionCreatorRequest(
            $rolePermission->roleId(),
            $rolePermission->permissionId()
        ));
    }

}
