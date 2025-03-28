<?php

declare(strict_types=1);

namespace Accounting\AccountingAccounts\Application\Update;

use Mockery\MockInterface;
use Tests\Backoffice\Accounting\AccountingAccounts\AccountingAccountUnitTestCase;
use MedineTech\Backoffice\Accounting\AccountingAccounts\Application\Update\AccountingAccountUpdater;
use MedineTech\Backoffice\Accounting\AccountingAccounts\Application\Update\AccountingAccountUpdaterRequest;
use MedineTech\Backoffice\Accounting\AccountingAccounts\Domain\AccountingAccountRepository;
use MedineTech\Backoffice\Accounting\AccountingAccounts\Domain\AccountingAccountStatus;
use MedineTech\Backoffice\Accounting\AccountingAccounts\Domain\AccountingAccountType;
use MedineTech\Shared\Domain\ValueObject\Uuid;
use PHPUnit\Framework\Attributes\Test;
use Tests\Backoffice\Accounting\AccountingAccounts\Domain\AccountingAccountMother;

final class AccountingAccountUpdaterTest extends AccountingAccountUnitTestCase
{
    #[test]
    public function it_should_update_an_accounting_account(): void
    {
        $id = Uuid::random()->value();
        $originalAccountingAccount = AccountingAccountMother::create(
            $id
        );

        $newName = 'new name';
        $newDescription = 'new description';
        $newType = AccountingAccountType::ASSET;
        $newStatus = AccountingAccountStatus::INACTIVE;
        $updaterId = 1;
        $parentId = Uuid::random()->value();

        $originalAccountingAccount->changeName($newName);
        $originalAccountingAccount->changeDescription($newDescription);
        $originalAccountingAccount->changeType($newType);
        $originalAccountingAccount->changeStatus($newStatus);
        $originalAccountingAccount->changeParentId($parentId);
        $originalAccountingAccount->changeUpdaterId($updaterId);

        /** @var AccountingAccountRepository&MockInterface $accountingAccountRepository */
        $accountingAccountRepository = $this->repository();
        $this->shouldFind($originalAccountingAccount->id(), $originalAccountingAccount);
        $this->shouldSave($originalAccountingAccount);

        $updater = new AccountingAccountUpdater($accountingAccountRepository);
        ($updater)(new AccountingAccountUpdaterRequest(
            $originalAccountingAccount->id(),
            $newName,
            $newDescription,
            $newType,
            $newStatus,
            $updaterId,
            $parentId,
        ));
    }
}
