<?php

declare(strict_types=1);

namespace Tests\Backoffice\Security\Roles\Application\Find;

use MedineTech\Backoffice\Security\Roles\Application\Find\RoleFinder;
use MedineTech\Backoffice\Security\Roles\Application\Find\RoleFinderRequest;
use MedineTech\Backoffice\Security\Roles\Domain\RoleRepository;
use PHPUnit\Framework\Attributes\Test;
use Tests\Backoffice\Security\Roles\RoleUnitTestCase;
use Tests\Backoffice\Security\Roles\Domain\RoleMother;

class RoleFinderTest extends RoleUnitTestCase
{
    #[Test]
    public function it_should_find_an_roles(): void
    {
        $id = 1;
        $role = RoleMother::create($id);

        /** @var RoleRepository $repository */
        $repository = $this->repository();
        $this->shouldFind($role->id(), $role);

        $finder = new RoleFinder($repository);
        ($finder)(new RoleFinderRequest($role->id()));
    }
}
