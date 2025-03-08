<?php

declare(strict_types=1);

namespace Tests\Backoffice\Users\Application\Create;

use MedineTech\Backoffice\Users\Application\Create\UserCreator;
use MedineTech\Backoffice\Users\Application\Create\UserCreatorRequest;
use MedineTech\Backoffice\Users\Domain\UserRepository;
use PHPUnit\Framework\Attributes\Test;
use Tests\Backoffice\Users\Domain\UserMother;
use Tests\Shared\Infrastructure\PhpUnit\UnitTestCase;

final class UserCreatorTest extends UnitTestCase
{
    #[Test]
    public function it_should_create_user(): void
    {
        $userId = 1;
        $user = UserMother::create(id: $userId);

        $userRepository = $this->mock(UserRepository::class);

        $userRepository->shouldReceive('nextId')
            ->once()
            ->andReturn($userId);

        $userRepository->shouldReceive('save')
            ->once()
            ->with($this->similarTo($user))
            ->andReturn($userId);

        $request = new UserCreatorRequest(
            $user->name(),
            $user->email(),
            $user->password()
        );

        /** @var UserRepository $userRepository */
        $creator = new UserCreator($userRepository);
        ($creator)($request);
    }
}
