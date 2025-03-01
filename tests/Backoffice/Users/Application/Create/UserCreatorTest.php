<?php

declare(strict_types=1);

namespace Tests\Backoffice\Users\Application\Create;

use MedineTech\Users\Application\Create\UserCreator;
use MedineTech\Users\Application\Create\UserCreatorRequest;
use MedineTech\Users\Domain\User;
use MedineTech\Users\Domain\UserAlreadyExists;
use MedineTech\Users\Domain\UserEmail;
use MedineTech\Users\Domain\UserRepository;
use Mockery;
use PHPUnit\Framework\Attributes\Test;
use Tests\Backoffice\Users\Domain\UserMother;
use Tests\Shared\Infrastructure\PhpUnit\UnitTestCase;

final class UserCreatorTest extends UnitTestCase
{
    #[Test]
    public function it_should_create_user(): void
    {
        $expectedUser = UserMother::create();

        /** @var UserRepository|Mockery\MockInterface $userRepository */
        $userRepository = $this->mock(UserRepository::class);

        $userRepository->shouldReceive('findByEmail')
            ->once()
            ->with(Mockery::on(function (UserEmail $email) use ($expectedUser): bool {
                return $email->value() === $expectedUser->email();
            }))
            ->andReturnNull();

        $userRepository->shouldReceive('nextId')
            ->once()
            ->andReturn(1);

        $userRepository->shouldReceive('save')
            ->once()
            ->with(Mockery::on(function (User $user) use ($expectedUser): bool {
                return
                    $user->name() === $expectedUser->name() &&
                    $user->email() === $expectedUser->email() &&
                    $user->password() === $expectedUser->password() &&
                    $user->id() === 1;
            }))
            ->andReturnNull();

        $request = new UserCreatorRequest(
            $expectedUser->name(),
            $expectedUser->email(),
            $expectedUser->password()
        );

        $creator = new UserCreator($userRepository);
        ($creator)($request);
    }

    #[Test]
    public function it_should_throw_exception_when_user_already_exists(): void
    {
        $this->expectException(UserAlreadyExists::class);

        $existingUser = UserMother::create();

        /** @var UserRepository|Mockery\MockInterface $userRepository */
        $userRepository = $this->mock(UserRepository::class);
        $userRepository->shouldReceive('findByEmail')
            ->once()
            ->with(Mockery::on(function (UserEmail $email) use ($existingUser): bool {
                return $email->value() === $existingUser->email();
            }))
            ->andReturn($existingUser);

        $request = new UserCreatorRequest(
            $existingUser->name(),
            $existingUser->email(),
            $existingUser->password()
        );

        $creator = new UserCreator($userRepository);
        ($creator)($request);
    }
}
