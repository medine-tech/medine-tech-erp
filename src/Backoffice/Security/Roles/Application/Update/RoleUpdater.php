<?php

declare(strict_types=1);

namespace MedineTech\Backoffice\Security\Roles\Application\Update;

use MedineTech\Backoffice\Security\Roles\Domain\RoleNotFound;
use MedineTech\Backoffice\Security\Roles\Domain\RoleRepository;

final readonly class RoleUpdater
{
    public function __construct(
        private readonly RoleRepository $repository
    )
    {
    }

    public function __invoke(RoleUpdaterRequest $request): void
    {
        $role = $this->repository->find($request->id());

        if (null === $role) {
            throw new RoleNotFound($request->id());
        }

        $role->changeName($request->name());
        $role->changeDescription($request->description());
        $role->changeStatus($request->status());
        $role->changeUpdaterId($request->updaterId());

        $this->repository->save($role);
    }
}
