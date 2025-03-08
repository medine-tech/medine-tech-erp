<?php
declare(strict_types=1);

namespace MedineTech\Backoffice\Users\Application\Create;

use MedineTech\Backoffice\Users\Domain\User;
use MedineTech\Backoffice\Users\Domain\UserRepository;

class UserCreator
{
    public function __construct(
        private UserRepository $repository
    ) {
    }

    public function __invoke(UserCreatorRequest $request): int
    {
        $id = $this->repository->nextId();

        $user = User::create(
            $id,
            $request->name(),
            $request->email(),
            $request->password()
        );

        return $this->repository->save($user);
    }
}
