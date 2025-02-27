<?php

declare(strict_types=1);

namespace MedineTech\Users\Application\Create;

use MedineTech\Users\Domain\User;
use MedineTech\Users\Domain\UserRepository;

final class UserCreator
{

    public function __construct(
       private readonly UserRepository $repository
    )
    {
    }

    public function __invoke(UserCreatorRequest $request): void
    {
        $user = User::create(
            $request->name(),
            $request->email(),
            $request->password()
        );

        $this->repository->save($user);
    }
}
