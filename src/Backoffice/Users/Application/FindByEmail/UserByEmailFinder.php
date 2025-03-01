<?php

declare(strict_types=1);

namespace MedineTech\Backoffice\Users\Application\FindByEmail;

use MedineTech\Backoffice\Users\Domain\UserDoesNotExists;
use MedineTech\Backoffice\Users\Domain\UserRepository;

final readonly class UserByEmailFinder
{
    public function __construct(
        private UserRepository $repository
    ) {
    }

    public function __invoke(UserByEmailFinderRequest $request): UserByEmailFinderResponse
    {
        $user = $this->repository->findByEmail($request->email());

        if ($user === null) {
            throw new UserDoesNotExists($request->email());
        }

        return new UserByEmailFinderResponse(
            $user->id(),
            $user->name(),
            $user->email(),
        );
    }
}
