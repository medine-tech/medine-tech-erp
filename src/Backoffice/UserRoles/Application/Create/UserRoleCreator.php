<?php

declare(strict_types=1);

namespace MedineTech\Backoffice\UserRoles\Application\Create;

use MedineTech\Backoffice\UserRoles\Domain\UserRole;
use MedineTech\Backoffice\UserRoles\Domain\UserRoleRepository;

class UserRoleCreator
{
    public function __construct(
        private readonly UserRoleRepository $repository
    ) {
    }

    public function __invoke(UserRoleCreatorRequest $request): void
    {
        $userRole = UserRole::create(
            $request->userId(),
            $request->roleId(),
            $request->companyId()
        );

        $this->repository->save($userRole);
    }
}
