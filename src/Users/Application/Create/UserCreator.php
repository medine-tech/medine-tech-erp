<?php
// File: src/Users/Application/Create/UserCreator.php

declare(strict_types=1);

namespace MedineTech\Users\Application\Create;

use MedineTech\Users\Domain\User;
use MedineTech\Users\Domain\UserAlreadyExists;
use MedineTech\Users\Domain\UserEmail;
use MedineTech\Users\Domain\UserRepository;

final class UserCreator
{
    public function __construct(
        private readonly UserRepository $repository
    ) {}

    public function __invoke(UserCreatorRequest $request): void
    {
        $email = new UserEmail($request->email());
        if ($this->repository->findByEmail($email)) {
            throw new UserAlreadyExists($request->email());
        }

        $id = $this->repository->nextId();

        $user = new User(
            $id,
            $request->name(),
            $request->email(),
            $request->password()
        );

        $this->repository->save($user);
    }
}
