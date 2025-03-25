<?php

declare(strict_types=1);

namespace MedineTech\Auth\Users\Application\Search;

use MedineTech\Auth\Users\Domain\AuthUser;
use MedineTech\Auth\Users\Domain\AuthUserRepository;
use function Lambdish\Phunctional\map;

class AuthUsersSearcher
{
    public function __construct(
        private readonly AuthUserRepository $repository
    ) {
    }

    public function __invoke(AuthUsersSearcherRequest $request): AuthUsersSearcherResponse
    {
        $result = $this->repository->search($request->filters());

        return new AuthUsersSearcherResponse(
            map(function (AuthUser $authUser) {
                return new AuthUserSearcherResponse(
                    $authUser->id(),
                    $authUser->name(),
                    $authUser->email(),
                    $authUser->defaultCompanyId()
                );
            }, $result["items"]),
            $result["total"],
            $result["perPage"],
            $result["currentPage"]
        );
    }
}
