<?php

declare(strict_types=1);

namespace Tests\UserTest\Application\Create;

use MedineTech\Users\Application\Create\UserCreator;
use MedineTech\Users\Application\Create\UserCreatorRequest;
use MedineTech\Users\Domain\UserRepository;
use PHPUnit\Framework\Attributes\Test;
use Tests\Shared\Infrastructure\PhpUnit\UnitTestCase;
use Tests\UserTest\Domain\UserMother;

final class UserCreatorTest extends UnitTestCase
{

    #[test]
    public function it_should_create_user(): void
    {
        $user = UserMother::create();

        /** @var UserRepository|\Mockery\MockInterface $userRepository */
        $userRepository = $this->mock(UserRepository::class);
        $userRepository->shouldReceive('save')
            ->once()
            ->with($this->similarTo($user))
            ->andReturnNull();

        $request = new UserCreatorRequest([
            'name'     => $user->name(),
            'email'    => $user->email(),
            'password' => $user->password()
        ]);

        $creator = new UserCreator($userRepository);
        ($creator)($request);

        $this->assertTrue(true);
    }
}
