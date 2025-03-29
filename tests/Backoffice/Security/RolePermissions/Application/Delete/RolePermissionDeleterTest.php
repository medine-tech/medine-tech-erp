<?php

declare(strict_types=1);

namespace Tests\Backoffice\Security\RolePermissions\Application\Delete;

use MedineTech\Backoffice\Security\RolePermissions\Application\Delete\RolePermissionDeleter;
use MedineTech\Backoffice\Security\RolePermissions\Application\Delete\RolePermissionDeleterRequest;
use MedineTech\Backoffice\Security\RolePermissions\Domain\RolePermissionRepository;
use Mockery\MockInterface;
use PHPUnit\Framework\Attributes\Test;
use Tests\Backoffice\Security\RolePermissions\Domain\RolePermissionMother;
use Tests\Shared\Infrastructure\PhpUnit\UnitTestCase;

final class RolePermissionDeleterTest extends UnitTestCase
{
    #[Test]
    public function it_should_delete_role_permission(): void
    {
        $rolePermission = RolePermissionMother::create();

        $rolePermissionRepository = $this->mock(RolePermissionRepository::class);

        $rolePermissionRepository->shouldReceive('find')
            ->once()
            ->with($rolePermission->roleId(), $rolePermission->permissionId())
            ->andReturn($rolePermission);

        $rolePermissionRepository->shouldReceive('delete')
            ->once()
            ->with($this->similarTo($rolePermission))
            ->andReturnNull();

        /** @var RolePermissionRepository&MockInterface $rolePermissionRepository */
        $deleter = new RolePermissionDeleter(
            $rolePermissionRepository
        );

        ($deleter)(new RolePermissionDeleterRequest(
            $rolePermission->roleId(),
            $rolePermission->permissionId()
        ));


    }
}
