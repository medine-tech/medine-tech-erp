<?php

namespace MedineTech\Backoffice\Users\Application\Find;

use MedineTech\Backoffice\Users\Domain\UserNotFound;
use MedineTech\Backoffice\Users\Domain\UserRepository;

final class UserFinder
{
    public function __construct(
        private UserRepository $repository
    ) {
    }

    public function __invoke(UserFinderRequest $request): UserFinderResponse
    {
        $user = $this->repository->find($request->id());

        if (null === $user) {
            throw new UserNotFound($request->id());
        }

        return new UserFinderResponse(
            $user->id(),
            $user->name(),
            $user->email(),
        );
    }
}
