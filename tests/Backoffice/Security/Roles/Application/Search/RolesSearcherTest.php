<?php

declare(strict_types=1);

namespace Security\Roles\Application\Search;

use MedineTech\Backoffice\Security\Roles\Application\Search\RolesSearcher;
use MedineTech\Backoffice\Security\Roles\Application\Search\RolesSearcherRequest;
use MedineTech\Backoffice\Security\Roles\Domain\RoleRepository;
use PHPUnit\Framework\Attributes\Test;
use Tests\Backoffice\Security\Roles\Domain\RoleMother;
use Tests\Shared\Infrastructure\PhpUnit\UnitTestCase;

final class RolesSearcherTest extends UnitTestCase
{
    #[Test]
    public function it_should_search_roles(): void
    {
        $role = RoleMother::create();
        $filters = ["id" => $role->id()];

        $roleRepository = $this->mock(RoleRepository::class);

        $roleRepository->shouldReceive('search')
            ->once()
            ->with($filters)
            ->andReturn([
                "items" => [$role],
                "total" => 1,
                "perPage" => 10,
                "currentPage" => 1
            ]);

        /** @var RoleRepository $roleRepository */
        $searcher = new RolesSearcher($roleRepository);
        ($searcher)(new RolesSearcherRequest($filters));
    }
}
