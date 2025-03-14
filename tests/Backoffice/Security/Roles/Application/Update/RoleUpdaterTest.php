<?php

declare(strict_types=1);

namespace Security\Roles\Application\Update;

use MedineTech\Backoffice\Security\Roles\Application\Update\RoleUpdater;
use MedineTech\Backoffice\Security\Roles\Application\Update\RoleUpdaterRequest;
use MedineTech\Backoffice\Security\Roles\Domain\RoleRepository;
use MedineTech\Backoffice\Security\Roles\Domain\RoleStatus;
use PHPUnit\Framework\Attributes\Test;
use Tests\Backoffice\Security\Roles\Domain\RoleMother;
use Tests\Backoffice\Security\Roles\RoleUnitTestCase;

final class RoleUpdaterTest extends RoleUnitTestCase
{
    #[Test]
    public function it_should_update_role(): void
    {
        $id = 1;
        $originalRole = RoleMother::create(
            id: $id,
        );

        $newName = 'new name';
        $newDescription = 'new description';
        $newStatus = RoleStatus::INACTIVE;
        $updaterId = 1;

        $originalRole->changeName($newName);
        $originalRole->changeDescription($newDescription);
        $originalRole->changeStatus($newStatus);

        /** @var RoleRepository $roleRepository */
        $repository = $this->repository();
        $this->shouldFind($originalRole->id(), $originalRole);
        $this->shouldSave($originalRole);


        $updater = new RoleUpdater($repository);

        ($updater)(new RoleUpdaterRequest(
            $id,
            $newName,
            $newDescription,
            $newStatus,
            $updaterId,
            $originalRole->companyId()
        ));
    }
}
