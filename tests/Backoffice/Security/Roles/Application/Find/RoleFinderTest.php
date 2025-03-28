<?php

declare(strict_types=1);

namespace Tests\Backoffice\Security\Roles\Application\Find;

use MedineTech\Backoffice\Security\Roles\Application\Find\RoleFinder;
use MedineTech\Backoffice\Security\Roles\Application\Find\RoleFinderRequest;
use MedineTech\Backoffice\Security\Roles\Domain\RoleRepository;
use Mockery\MockInterface;
use PHPUnit\Framework\Attributes\Test;
use Tests\Backoffice\Security\Roles\RoleUnitTestCase;
use Tests\Backoffice\Security\Roles\Domain\RoleMother;

class RoleFinderTest extends RoleUnitTestCase
{
    #[Test]
    public function it_should_find_a_role(): void
    {
        $id = 1;
        $role = RoleMother::create($id);

        /** @var RoleRepository&MockInterface $roleRepository */
        $roleRepository = $this->repository();
        $this->shouldFind($role->id(), $role);

        $finder = new RoleFinder($roleRepository);
        ($finder)(new RoleFinderRequest($role->id()));
    }
}
