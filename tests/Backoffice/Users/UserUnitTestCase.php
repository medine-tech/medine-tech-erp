<?php
declare(strict_types=1);

namespace Tests\Backoffice\Users;

use MedineTech\Backoffice\Users\Application\Create\UserCreator;
use MedineTech\Backoffice\Users\Application\Create\UserCreatorRequest;
use MedineTech\Backoffice\Users\Domain\UserRepository;
use Tests\Backoffice\Users\Domain\UserMother;
use Tests\Shared\Infrastructure\PhpUnit\UnitTestCase;

final class UserUnitTestCase extends UnitTestCase
{
    /**
     * @test
     */
    public function it_should_create_user(): void
    {
        $user = UserMother::create();

        /** @var UserRepository|\Mockery\MockInterface $userRepository */
        $userRepository = $this->mock(UserRepository::class);
        $userRepository->shouldReceive('save')
            ->once()
            ->with($user)
            ->andReturnNull();

        $creator = new UserCreator($userRepository);
        $response = ($creator)(new UserCreatorRequest([
            'id'       => $user->id(),
            'name'     => $user->name(),
            'email'    => $user->email(),
            'password' => $user->password()
        ]));

        $this->assertTrue(true);
    }
}
