<?php
declare(strict_types=1);

namespace MedineTech\Users\Application\Update;

use DomainException;
use MedineTech\Users\Domain\User;
use MedineTech\Users\Domain\UserEmail;
use MedineTech\Users\Domain\UserRepository;

final class UserUpdater
{
    public function __construct(
        private readonly UserRepository $repository
    ) {}

    public function __invoke(UserUpdaterRequest $request): void
    {
        $existingUser = $this->repository->find($request->id());
        if (!$existingUser) {
            throw new DomainException('User not found.');
        }

        $userWithEmail = $this->repository->findByEmail(new UserEmail($request->email()));
        if ($userWithEmail && $userWithEmail->id() !== $request->id()) {
            throw new DomainException('Email is already in use.');
        }

        $updatedUser = new User(
            $request->id(),
            $request->name(),
            $request->email(),
            $request->password()
        );

        $this->repository->save($updatedUser);
    }
}
