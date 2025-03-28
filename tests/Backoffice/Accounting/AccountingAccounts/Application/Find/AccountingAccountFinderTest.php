<?php

declare(strict_types=1);

namespace Tests\Backoffice\Accounting\AccountingAccounts\Application\Find;

use MedineTech\Backoffice\Accounting\AccountingAccounts\Application\Find\AccountingAccountFinder;
use MedineTech\Backoffice\Accounting\AccountingAccounts\Application\Find\AccountingAccountFinderRequest;
use MedineTech\Backoffice\Accounting\AccountingAccounts\Domain\AccountingAccountRepository;
use MedineTech\Shared\Domain\ValueObject\Uuid;
use Mockery\MockInterface;
use PHPUnit\Framework\Attributes\Test;
use Tests\Backoffice\Accounting\AccountingAccounts\AccountingAccountUnitTestCase;
use Tests\Backoffice\Accounting\AccountingAccounts\Domain\AccountingAccountMother;

class AccountingAccountFinderTest extends AccountingAccountUnitTestCase
{
    #[test]
    public function it_should_find_an_accounting_account(): void
    {
        $id = Uuid::random()->value();
        $accountingAccount = AccountingAccountMother::create($id);

        /** @var AccountingAccountRepository&MockInterface $repository */
        $repository = $this->repository();
        $this->shouldFind($accountingAccount->id(), $accountingAccount);

        $finder = new AccountingAccountFinder($repository);
        ($finder)(new AccountingAccountFinderRequest($accountingAccount->id()));
    }
}
