<?php
declare(strict_types=1);

namespace Tests\Unit\UserTest\Application\Create;

use MedineTech\Users\Application\Create\UserCreator;
use MedineTech\Users\Application\Create\UserCreatorRequest;
use MedineTech\Users\Domain\UserRepository;
use Tests\Shared\Infrastructure\PhpUnit\UnitTestCase;
use Tests\Unit\UserTest\Domain\UserMother;
use Mockery;

final class UserCreatorTest extends UnitTestCase
{
    /**
     * @test
     */
    public function it_should_create_user(): void
    {
        $user = UserMother::create();

        /** @var UserRepository|Mockery\MockInterface $userRepository */
        $userRepository = $this->mock(UserRepository::class);
        $userRepository->shouldReceive('save')
            ->once()
            ->with(Mockery::type(\MedineTech\Users\Domain\User::class))
            ->andReturnNull();

        $request = new UserCreatorRequest([
            'id'       => $user->id(),
            'name'     => $user->name() . "dsada",
            'email'    => $user->email(),
            'password' => $user->password()
        ]);

        $creator = new UserCreator($userRepository);
        ($creator)($request);

        $this->assertTrue(true);
    }
}
