<?php

declare(strict_types=1);

namespace MedineTech\Users\Application\Create;

use MedineTech\Users\Domain\User;
use MedineTech\Users\Domain\UserRepository;

final class UserCreator
{
    private UserRepository $repository;

    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(UserCreatorRequest $request): void
    {
        $user = User::create(
            $request->id(),
            $request->name(),
            $request->email(),
            $request->password()
        );

        $this->repository->save($user);
    }
}
