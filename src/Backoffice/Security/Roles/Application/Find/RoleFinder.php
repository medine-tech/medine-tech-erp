<?php

declare(strict_types=1);

namespace MedineTech\Backoffice\Security\Roles\Application\Find;

use MedineTech\Backoffice\Security\Roles\Domain\RoleNotFound;
use MedineTech\Backoffice\Security\Roles\Domain\RoleRepository;

final readonly class RoleFinder
{
    public function __construct(
        private readonly RoleRepository $repository
    )
    {
    }

    public function __invoke(RoleFinderRequest $request): RoleResponse
    {
        $role = $this->repository->find($request->id());

        if (null === $role) {
            throw new RoleNotFound($request->id());
        }

        return new RoleResponse(
            $role->id(),
            $role->code(),
            $role->name(),
            $role->description(),
            $role->status(),
            $role->creatorId(),
            $role->updaterId(),
            $role->companyId()
        );
    }
}
