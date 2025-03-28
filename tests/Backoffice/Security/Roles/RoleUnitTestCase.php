<?php

declare(strict_types=1);

namespace Tests\Backoffice\Security\Roles;

use MedineTech\Backoffice\Security\Roles\Domain\Role;
use MedineTech\Backoffice\Security\Roles\Domain\RoleRepository;
use Mockery\MockInterface;
use Tests\Shared\Infrastructure\PhpUnit\UnitTestCase;

Abstract class RoleUnitTestCase extends UnitTestCase
{
    private ?MockInterface $repository = null;

    protected function repository(): MockInterface
    {
        if ($this->repository) {
            return $this->repository;
        }

        return $this->repository = $this->mock(RoleRepository::class);
    }

    protected function shouldSave(Role $role): void
    {
        $this->repository()
            ->shouldReceive('save')
            ->once()
            ->with($this->similarTo($role))
            ->andReturn($role->id());
    }

    protected function shouldFind(int $id, ?Role $role): void
    {
        $this->repository()
            ->shouldReceive('find')
            ->once()
            ->with($this->similarTo($id))
            ->andReturn($role);
    }

    protected function shouldNotFind(int $id): void
    {
        $this->repository()
            ->shouldReceive('find')
            ->once()
            ->with($this->similarTo($id))
            ->andReturnNull();
    }
}
