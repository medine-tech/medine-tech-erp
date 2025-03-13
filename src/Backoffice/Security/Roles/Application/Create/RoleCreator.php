<?php

declare(strict_types=1);

namespace MedineTech\Backoffice\Security\Roles\Application\Create;

use MedineTech\Backoffice\Security\Roles\Domain\Role;
use MedineTech\Backoffice\Security\Roles\Domain\RoleRepository;
use MedineTech\Shared\Domain\Bus\Event\EventBus;

class RoleCreator
{
    public function __construct(
        private readonly RoleRepository $repository,
        private readonly EventBus $eventBus
    )
    {
    }

    public function __invoke(RoleCreatorRequest $request): void
    {
        $code = $this->repository->nextCode('company_id');

        $role = Role::create(
            $request->id(),
            $code,
            $request->name(),
            $request->description(),
            $request->creatorId(),
            $request->companyId()
        );

        $this->repository->save($role);

        $this->eventBus->publish(...$role->pullDomainEvents());
    }
}
