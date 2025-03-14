<?php

declare(strict_types=1);

namespace MedineTech\Backoffice\Security\Roles\Application\Search;

use MedineTech\Backoffice\Security\Roles\Domain\Role;
use MedineTech\Backoffice\Security\Roles\Domain\RoleRepository;
use function Lambdish\Phunctional\map;

class RolesSearcher
{
    public function __construct(
        private readonly RoleRepository $repository
    )
    {
    }

    public function __invoke(RolesSearcherRequest $request): RolesSearcherResponse
    {
        $result = $this->repository->search($request->filters());

        return new RolesSearcherResponse(
            map(function (Role $role) {
                return new RoleSearcherResponse(
                    $role->id(),
                    $role->code(),
                    $role->name(),
                    $role->description(),
                    $role->status(),
                    $role->creatorId(),
                    $role->updaterId(),
                    $role->companyId(),
                );
            }, $result["items"]),
            $result["total"],
            $result["perPage"],
            $result["currentPage"]
        );
    }
}
