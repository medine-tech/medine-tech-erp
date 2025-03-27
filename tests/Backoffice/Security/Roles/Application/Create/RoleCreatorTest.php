<?php

declare(strict_types=1);

namespace Tests\Backoffice\Security\Roles\Application\Create;

use MedineTech\Backoffice\Security\Roles\Application\Create\RoleCreator;
use MedineTech\Backoffice\Security\Roles\Application\Create\RoleCreatorRequest;
use MedineTech\Backoffice\Security\Roles\Domain\RoleCreatedDomainEvent;
use MedineTech\Backoffice\Security\Roles\Domain\RoleRepository;
use MedineTech\Backoffice\Security\Roles\Domain\RoleStatus;
use Mockery\MockInterface;
use PHPUnit\Framework\Attributes\Test;
use Tests\Backoffice\Security\Roles\Domain\RoleMother;
use Tests\Shared\Infrastructure\PhpUnit\UnitTestCase;

final class RoleCreatorTest extends UnitTestCase
{
    #[Test]
    public function it_should_create_role(): void
    {
        $roleId = 1;
        $role = RoleMother::create(
            status: RoleStatus::ACTIVE
        );

        $roleRepository = $this->mock(RoleRepository::class);

        $roleRepository->shouldReceive('nextCode')
            ->once()
            ->andReturn($role->code());

        $roleRepository->shouldReceive('save')
            ->once()
            ->with($this->similarTo($role))
            ->andReturnNull();

        $eventBus = $this->eventBus();
        $event = new RoleCreatedDomainEvent(
            (string)$roleId,
            $role->code(),
            $role->name(),
            $role->description(),
            $role->status(),
            $role->creatorId(),
            $role->updaterId(),
            $role->companyId()
        );

        $this->shouldPublishDomainEvent($event);

        /** @var RoleRepository&MockInterface $roleRepository */
        $creator = new RoleCreator(
            $roleRepository,
            $eventBus
        );

        ($creator)(new RoleCreatorRequest(
            $role->name(),
            $role->description(),
            $role->creatorId(),
            $role->companyId()
        ));
    }
}
