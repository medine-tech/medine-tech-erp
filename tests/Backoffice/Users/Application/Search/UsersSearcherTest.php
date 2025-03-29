<?php

declare(strict_types=1);

namespace Tests\Backoffice\Users\Application\Search;

use MedineTech\Backoffice\Users\Application\Search\UsersSearcher;
use MedineTech\Backoffice\Users\Application\Search\UsersSearcherRequest;
use MedineTech\Backoffice\Users\Domain\UserRepository;
use Mockery\MockInterface;
use PHPUnit\Framework\Attributes\Test;
use Tests\Backoffice\Users\Domain\UserMother;
use Tests\Shared\Infrastructure\PhpUnit\UnitTestCase;

final class UsersSearcherTest extends UnitTestCase
{
    #[Test]
    public function it_should_search_users(): void
    {
        $user = UserMother::create();
        $filters = ["email" => $user->email(),];

        $userRepository = $this->mock(UserRepository::class);
        $userRepository->shouldReceive('search')
            ->once()
            ->with($filters)
            ->andReturn([
                "items" => [$user],
                "total" => 1,
                "perPage" => 10,
                "currentPage" => 1,
            ]);

        /** @var UserRepository&MockInterface $userRepository */
        $searcher = new UsersSearcher($userRepository);
        ($searcher)(new UsersSearcherRequest(
            $filters
        ));
    }
}
