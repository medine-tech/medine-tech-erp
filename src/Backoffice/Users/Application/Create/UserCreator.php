<?php
declare(strict_types=1);

namespace MedineTech\Backoffice\Users\Application\Create;

use MedineTech\Backoffice\Users\Domain\User;
use MedineTech\Backoffice\Users\Domain\UserAlreadyExists;
use MedineTech\Backoffice\Users\Domain\UserRepository;
use MedineTech\Backoffice\Users\Domain\UserEmail;

final readonly class UserCreator
{
    public function __construct(
        private UserRepository $repository
    ) {
    }

    public function __invoke(UserCreatorRequest $request): void
    {
        $this->ensureUserDoesNotExists($request);

        $id = $this->repository->nextId();

        $user = new User(
            $id,
            $request->name(),
            new UserEmail($request->email()),
            $request->password()
        );

        $this->repository->create($user);
    }

    private function ensureUserDoesNotExists(UserCreatorRequest $request): void
    {
        if ($this->repository->findByEmail($request->email())) {
            throw new UserAlreadyExists($request->email());
        }
    }
}
