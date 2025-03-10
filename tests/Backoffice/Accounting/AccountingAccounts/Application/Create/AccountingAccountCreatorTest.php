<?php

declare(strict_types=1);

namespace Tests\Backoffice\Accounting\AccountingAccounts\Application\Create;

use Tests\Backoffice\Accounting\AccountingAccounts\Domain\AccountingAccountMother;
use MedineTech\Backoffice\Accounting\AccountingAccounts\Application\Create\AccountingAccountCreator;
use MedineTech\Backoffice\Accounting\AccountingAccounts\Application\Create\AccountingAccountCreatorRequest;
use MedineTech\Backoffice\Accounting\AccountingAccounts\Domain\AccountingAccountCreatedDomainEvent;
use MedineTech\Backoffice\Accounting\AccountingAccounts\Domain\AccountingAccountRepository;
use PHPUnit\Framework\Attributes\Test;
use Tests\Shared\Infrastructure\PhpUnit\UnitTestCase;

final class AccountingAccountCreatorTest extends UnitTestCase
{
    #[test]
    public function it_should_create_an_accounting_account(): void
    {
        $accountingAccount = AccountingAccountMother::create();

        $accountingAccountRepository = $this->mock(AccountingAccountRepository::class);
        $accountingAccountRepository->shouldReceive('save')
            ->once()
            ->with($this->similarTo($accountingAccount))
            ->andReturnNull();

        $eventBus = $this->eventBus();
        $domainEvent = new AccountingAccountCreatedDomainEvent(
            $accountingAccount->id(),
            $accountingAccount->name(),
            $accountingAccount->code(),
            $accountingAccount->type(),
            $accountingAccount->parentId(),
            $accountingAccount->status(),
            $accountingAccount->companyId()
        );
        $this->shouldPublishDomainEvent($domainEvent);

        /* @var AccountingAccountRepository $accountingAccountRepository */
        $creator = new AccountingAccountCreator(
            $accountingAccountRepository,
            $eventBus
        );

        ($creator)(new AccountingAccountCreatorRequest(
            $accountingAccount->id(),
            $accountingAccount->name(),
            $accountingAccount->code(),
            $accountingAccount->type(),
            $accountingAccount->parentId(),
            $accountingAccount->status(),
            $accountingAccount->companyId()
        ));
    }
}
