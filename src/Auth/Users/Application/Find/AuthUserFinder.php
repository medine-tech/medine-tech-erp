<?php

declare(strict_types=1);

namespace MedineTech\Auth\Users\Application\Find;

use MedineTech\Auth\Users\Domain\AuthUserNotFound;
use MedineTech\Auth\Users\Domain\AuthUserRepository;

final readonly class AuthUserFinder
{
    public function __construct(
        private readonly AuthUserRepository $repository
    ) {
    }

    public function __invoke(AuthUserFinderRequest $request): AuthUserFinderResponse
    {
        $user = $this->repository->find($request->id());

        if (null === $user) {
            throw new AuthUserNotFound($request->id());
        }

        return new AuthUserFinderResponse(
            $user->id(),
            $user->name(),
            $user->email(),
            $user->password()
        );
    }
}
