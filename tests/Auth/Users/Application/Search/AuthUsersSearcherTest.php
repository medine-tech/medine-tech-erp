<?php

declare(strict_types=1);

namespace Tests\Auth\Users\Application\Search;

use MedineTech\Auth\Users\Application\Search\AuthUsersSearcher;
use MedineTech\Auth\Users\Application\Search\AuthUsersSearcherRequest;
use MedineTech\Auth\Users\Domain\AuthUserRepository;
use PHPUnit\Framework\Attributes\Test;
use Tests\Auth\Users\Domain\AuthUserMother;
use Tests\Shared\Infrastructure\PhpUnit\UnitTestCase;

final class AuthUsersSearcherTest extends UnitTestCase
{
    #[Test]
    public function it_should_search_auth_users(): void
    {
        $user = AuthUserMother::create();
        $filters = ["email" => $user->email(),];

        $userRepository = $this->mock(AuthUserRepository::class);
        $userRepository->shouldReceive('search')
            ->once()
            ->with($filters)
            ->andReturn([
                "items" => [$user],
                "total" => 1,
                "perPage" => 10,
                "currentPage" => 1,
            ]);

        /** @var AuthUserRepository $userRepository */
        $searcher = new AuthUsersSearcher($userRepository);
        ($searcher)(new AuthUsersSearcherRequest($filters));
    }
}
