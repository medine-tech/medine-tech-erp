<?php

declare(strict_types=1);

namespace Tests\Backoffice\Users\Application\FindByEmail;

use MedineTech\Backoffice\Users\Application\FindByEmail\UserByEmailFinder;
use MedineTech\Backoffice\Users\Application\FindByEmail\UserByEmailFinderRequest;
use MedineTech\Backoffice\Users\Domain\UserRepository;
use Mockery\MockInterface;
use PHPUnit\Framework\Attributes\Test;
use Tests\Backoffice\Users\Domain\UserMother;
use Tests\Shared\Infrastructure\PhpUnit\UnitTestCase;

final class UserByEmailFinderTest extends UnitTestCase
{
    #[Test]
    public function it_should_find_a_user_by_email(): void
    {
        $user = UserMother::create();

        $userRepository = $this->mock(UserRepository::class);
        $userRepository->shouldReceive('findByEmail')
            ->once()
            ->with($user->email())
            ->andReturn($user);

        /** @var UserRepository&MockInterface $userRepository */
        $finder = new UserByEmailFinder($userRepository);
        ($finder)(new UserByEmailFinderRequest($user->email()));
    }
}
