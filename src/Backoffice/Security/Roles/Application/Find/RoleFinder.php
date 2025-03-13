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
        $accountingAccount = $this->repository->find($request->id());

        if (null === $accountingAccount) {
            throw new RoleNotFound($request->id());
        }

        return new RoleResponse(
            $accountingAccount->id(),
            $accountingAccount->code(),
            $accountingAccount->name(),
            $accountingAccount->description(),
            $accountingAccount->status(),
            $accountingAccount->creatorId(),
            $accountingAccount->updaterId(),
            $accountingAccount->companyId()
        );
    }
}
