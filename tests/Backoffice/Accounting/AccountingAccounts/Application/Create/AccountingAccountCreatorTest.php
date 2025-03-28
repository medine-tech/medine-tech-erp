<?php

declare(strict_types=1);

namespace Tests\Backoffice\Accounting\AccountingAccounts\Application\Create;

use MedineTech\Backoffice\Accounting\AccountingAccounts\Application\Create\AccountingAccountCreator;
use MedineTech\Backoffice\Accounting\AccountingAccounts\Application\Create\AccountingAccountCreatorRequest;
use MedineTech\Backoffice\Accounting\AccountingAccounts\Domain\AccountingAccountCreatedDomainEvent;
use MedineTech\Backoffice\Accounting\AccountingAccounts\Domain\AccountingAccountRepository;
use MedineTech\Backoffice\Accounting\AccountingAccounts\Domain\AccountingAccountStatus;
use Mockery\MockInterface;
use PHPUnit\Framework\Attributes\Test;
use Tests\Backoffice\Accounting\AccountingAccounts\Domain\AccountingAccountMother;
use Tests\Shared\Infrastructure\PhpUnit\UnitTestCase;

final class AccountingAccountCreatorTest extends UnitTestCase
{
    #[Test]
    public function it_should_create_an_accounting_account(): void
    {
        $accountingAccount = AccountingAccountMother::create(
            status: AccountingAccountStatus::ACTIVE
        );

        $accountingAccountRepository = $this->mock(AccountingAccountRepository::class);
        $accountingAccountRepository->shouldReceive('save')
            ->once()
            ->with($this->similarTo($accountingAccount))
            ->andReturnNull();

        $eventBus = $this->eventBus();

        $domainEvent = new AccountingAccountCreatedDomainEvent(
            $accountingAccount->id(),
            $accountingAccount->code(),
            $accountingAccount->name(),
            $accountingAccount->description(),
            $accountingAccount->type(),
            $accountingAccount->status(),
            $accountingAccount->parentId(),
            $accountingAccount->creatorId(),
            $accountingAccount->updaterId(),
            $accountingAccount->companyId()
        );
        $this->shouldPublishDomainEvent($domainEvent);

        /* @var AccountingAccountRepository&MockInterface $accountingAccountRepository */
        $creator = new AccountingAccountCreator(
            $accountingAccountRepository,
            $eventBus
        );

        ($creator)(new AccountingAccountCreatorRequest(
            $accountingAccount->id(),
            $accountingAccount->code(),
            $accountingAccount->name(),
            $accountingAccount->description(),
            $accountingAccount->type(),
            $accountingAccount->parentId(),
            $accountingAccount->creatorId(),
            $accountingAccount->companyId()
        ));
    }
}
