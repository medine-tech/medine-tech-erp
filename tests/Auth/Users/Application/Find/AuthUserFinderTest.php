<?php

declare(strict_types=1);

namespace Tests\Auth\Users\Application\Find;

use MedineTech\Auth\Users\Application\Find\AuthUserFinder;
use MedineTech\Auth\Users\Application\Find\AuthUserFinderRequest;
use MedineTech\Auth\Users\Domain\AuthUserRepository;
use Mockery\MockInterface;
use PHPUnit\Framework\Attributes\Test;
use Tests\Auth\Users\AuthUserUnitTestCase;
use Tests\Auth\Users\Domain\AuthUserMother;

class AuthUserFinderTest extends AuthUserUnitTestCase
{
    #[Test]
    public function it_should_find_a_auth_user(): void
    {
        $authUser = AuthUserMother::create();

        /** @var AuthUserRepository&MockInterface $repository */
        $repository = $this->repository();
        $this->shouldFind($authUser->id(), $authUser);

        $finder = new AuthUserFinder($repository);
        $response = ($finder)(new AuthUserFinderRequest($authUser->id()));

        $this->assertEquals($authUser->id(), $response->id());
        $this->assertEquals($authUser->name(), $response->name());
    }
}
