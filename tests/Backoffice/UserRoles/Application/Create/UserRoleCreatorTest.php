<?php

declare(strict_types=1);

namespace Tests\Backoffice\UserRoles\Application\Create;

use MedineTech\Backoffice\UserRoles\Application\Create\UserRoleCreator;
use MedineTech\Backoffice\UserRoles\Application\Create\UserRoleCreatorRequest;
use MedineTech\Backoffice\UserRoles\Domain\UserRoleRepository;
use Mockery\MockInterface;
use PHPUnit\Framework\Attributes\Test;
use Tests\Backoffice\UserRoles\Domain\UserRoleMother;
use Tests\Shared\Infrastructure\PhpUnit\UnitTestCase;

final class UserRoleCreatorTest extends UnitTestCase
{
    #[Test]
    public function it_should_create(): void
    {
        $userRole = UserRoleMother::create();
        $userRoleRepository = $this->mock(UserRoleRepository::class);
        $userRoleRepository->shouldReceive('save')
            ->once()
            ->with($this->similarTo($userRole))
            ->andReturnNull();

        /** @var UserRoleRepository&MockInterface $userRoleRepository */
        $creator = new UserRoleCreator(
            $userRoleRepository
        );
        ($creator)(new UserRoleCreatorRequest(
            $userRole->userId(),
            $userRole->roleId(),
            $userRole->companyId()
        ));
    }
}
