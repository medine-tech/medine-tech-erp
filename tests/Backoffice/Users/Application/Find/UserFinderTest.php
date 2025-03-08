<?php
namespace Tests\Backoffice\Users\Application\Find;

use Tests\Backoffice\Users\UserUnitTestCase;
use Tests\Backoffice\Users\Domain\UserMother;
use MedineTech\Backoffice\Users\Application\Find\UserFinder;
use MedineTech\Backoffice\Users\Application\Find\UserFinderRequest;
use PHPUnit\Framework\Attributes\Test;
use MedineTech\Backoffice\Users\Domain\UserRepository;

class UserFinderTest extends UserUnitTestCase
{
    #[Test]
    public function it_should_find_user(): void
    {
        $user = UserMother::create();
        $id = $user->id();

        $this->shouldFindUser($user->id(), $user);

        /** @var UserRepository $userRepository */
        $userRepository = $this->repository();

        $finder = new UserFinder($userRepository);
        ($finder)(new UserFinderRequest($id));
    }
}
