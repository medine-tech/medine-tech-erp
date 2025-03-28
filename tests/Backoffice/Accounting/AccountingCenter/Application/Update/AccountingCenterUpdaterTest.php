<?php
declare(strict_types=1);

namespace Tests\Backoffice\Accounting\AccountingCenter\Application\Update;

use MedineTech\Backoffice\Accounting\AccountingCenter\Application\Update\AccountingCenterUpdater;
use MedineTech\Backoffice\Accounting\AccountingCenter\Application\Update\AccountingCenterUpdaterRequest;
use MedineTech\Backoffice\Accounting\AccountingCenter\Domain\AccountingCenterRepository;
use MedineTech\Shared\Domain\ValueObject\Uuid;
use Mockery\MockInterface;
use PHPUnit\Framework\Attributes\Test;
use Tests\Backoffice\Accounting\AccountingCenter\AccountingCenterUnitTestCase;
use Tests\Backoffice\Accounting\AccountingCenter\Domain\AccountingCenterMother;

final class AccountingCenterUpdaterTest extends AccountingCenterUnitTestCase
{
    #[Test]
    public function it_should_update_an_accounting_center(): void
    {
        $id = Uuid::random()->value();
        $originalCenter = AccountingCenterMother::create($id);

        $newName = 'new center name';
        $newDescription = 'new center description';
        $newStatus = 'INACTIVE';
        $updaterId = 1;
        $parentId = Uuid::random()->value();

        // Apply the changes on the domain object
        $originalCenter->changeName($newName);
        $originalCenter->changeDescription($newDescription);
        $originalCenter->changeStatus($newStatus);
        $originalCenter->changeUpdaterId($updaterId);
        $originalCenter->changeParentId($parentId);

        /** @var AccountingCenterRepository&MockInterface $accountingCenterRepository */
        $accountingCenterRepository = $this->repository();
        $this->shouldFind($originalCenter->id(), $originalCenter);
        $this->shouldSave($originalCenter);

        $updater = new AccountingCenterUpdater($accountingCenterRepository);
        ($updater)(new AccountingCenterUpdaterRequest(
            $originalCenter->id(),
            $newName,
            $newDescription,
            $newStatus,
            $updaterId,
            $parentId
        ));
    }
}
