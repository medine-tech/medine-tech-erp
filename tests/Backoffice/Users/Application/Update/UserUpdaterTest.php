<?php
declare(strict_types=1);

namespace Tests\Backoffice\Users\Application\Update;

use MedineTech\Backoffice\Users\Application\Update\UserUpdater;
use MedineTech\Backoffice\Users\Application\Update\UserUpdaterRequest;
use MedineTech\Backoffice\Users\Domain\UserRepository;
use Mockery\MockInterface;
use PHPUnit\Framework\Attributes\Test;
use Tests\Backoffice\Users\Domain\UserMother;
use Tests\Backoffice\Users\UserUnitTestCase;

final class UserUpdaterTest extends UserUnitTestCase
{
    #[Test]
    public function it_should_update_an_entity_name(): void
    {
        $id = 1;
        $originalUser = UserMother::create($id);
        $newName = 'new name';

        /** @var UserRepository&MockInterface $UserRepository */
        $UserRepository = $this->repository();
        $this->shouldFindUser($originalUser->id(), $originalUser);
        $this->shouldSaveUser($originalUser);

        $updater = new UserUpdater($UserRepository);
        ($updater)(new UserUpdaterRequest(
            $originalUser->id(),
            $newName
        ));

        $this->assertEquals($newName, $originalUser->name());
    }
}
