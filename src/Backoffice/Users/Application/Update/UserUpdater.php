<?php
declare(strict_types=1);

namespace MedineTech\Backoffice\Users\Application\Update;

use DomainException;
use MedineTech\Backoffice\Users\Domain\UserEmail;
use MedineTech\Backoffice\Users\Domain\UserRepository;

final class UserUpdater
{
    public function __construct(
        private UserRepository $repository
    ) {}

    public function __invoke(UserUpdaterRequest $request): void
    {
        $existingUser = $this->repository->find($request->id());

        if (!$existingUser) {
            throw new DomainException('User not found.');
        }

        $email = new UserEmail($request->email());
        $userWithSameEmail = $this->repository->findByEmail($email->value());

        if ($userWithSameEmail && $userWithSameEmail->id() !== $request->id()) {
            throw new DomainException('Email is already in use.');
        }

        $existingUser->changeName($request->name());
        $existingUser->changeEmail($email);

        if ($request->password() !== null && $request->password() !== '') {
            $existingUser->changePassword($request->password());
        }

        $this->repository->save($existingUser);
    }
}
