<?php
declare(strict_types=1);

namespace MedineTech\Backoffice\Users\Application\Update;

use MedineTech\Backoffice\Users\Domain\UserNotFound;
use MedineTech\Backoffice\Users\Domain\UserRepository;

final class UserUpdater
{
    public function __construct(
        private UserRepository $repository
    ) {}

    public function __invoke(UserUpdaterRequest $request): void
    {
        $user = $this->repository->find($request->id());

        if ($user === null) {
            throw new UserNotFound($request->id());
        }

        $user->changeName($request->name());

        $this->repository->save($user);
    }
}
