<?php
declare(strict_types=1);

namespace Tests\Backoffice\Users\Application\Update;

use MedineTech\Backoffice\Users\Application\Update\UserUpdater;
use MedineTech\Backoffice\Users\Application\Update\UserUpdaterRequest;
use MedineTech\Users\Domain\User;
use MedineTech\Users\Domain\UserEmail;
use MedineTech\Users\Domain\UserRepository;
use PHPUnit\Framework\Attributes\Test;
use Tests\UserTest\Domain\UserMother;
use Tests\UserTest\UserUnitTestCase;

final class UserUpdaterTest extends UserUnitTestCase
{
    #[Test]
    public function it_should_update_user(): void
    {
        $userFromMother = UserMother::create();
        $existingUser = new User(
            1,
            $userFromMother->name(),
            $userFromMother->email(),
            $userFromMother->password()
        );

        $newName     = 'New Name';
        $newEmail    = 'newemail@example.com';
        $newPassword = $existingUser->password();

        $updatedUser = new User(
            $existingUser->id(),
            $newName,
            $newEmail,
            $newPassword
        );

        $userRepository = $this->repository();

        $userRepository->shouldReceive('find')
            ->once()
            ->with($existingUser->id())
            ->andReturn($existingUser);

        $userRepository->shouldReceive('findByEmail')
            ->once()
            ->with(\Mockery::on(function (UserEmail $email) use ($newEmail): bool {
                return $email->value() === $newEmail;
            }))
            ->andReturnNull();

        $userRepository->shouldReceive('save')
            ->once()
            ->with(\Mockery::on(function (User $user) use ($updatedUser): bool {
                return $user->id() === $updatedUser->id() &&
                    $user->name() === $updatedUser->name() &&
                    $user->email() === $updatedUser->email() &&
                    $user->password() === $updatedUser->password();
            }))
            ->andReturnNull();

        $request = new UserUpdaterRequest(
            $existingUser->id(),
            $newName,
            $newEmail,
            $newPassword
        );

        /** @var UserRepository $userRepository */
        $updater = new UserUpdater($userRepository);
        ($updater)($request);


    }
}
