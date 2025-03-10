<?php

declare(strict_types=1);

namespace Tests\Backoffice\Accounting\AccountingCenter\Application\Create;

use Mockery;
use Tests\Backoffice\Accounting\AccountingCenter\Domain\AccountingCenterMother;
use MedineTech\Backoffice\Accounting\AccountingCenter\Application\Create\AccountingCenterCreator;
use MedineTech\Backoffice\Accounting\AccountingCenter\Application\Create\AccountingCenterCreatorRequest;
use MedineTech\Backoffice\Accounting\AccountingCenter\Domain\AccountingCenterCreatedDomainEvent;
use MedineTech\Backoffice\Accounting\AccountingCenter\Domain\AccountingCenterRepository;
use PHPUnit\Framework\Attributes\Test;
use Tests\Shared\Infrastructure\PhpUnit\UnitTestCase;

final class AccountingCenterCreatorTest extends UnitTestCase
{
    #[Test]
    public function it_should_create_an_accounting_center(): void
    {
        $accountingCenter = AccountingCenterMother::create();

        /** @var AccountingCenterRepository|Mockery\MockInterface $repository */
        $repository = Mockery::mock(AccountingCenterRepository::class);
        $repository->shouldReceive('save')
            ->once()
            ->with($this->similarTo($accountingCenter))
            ->andReturnNull();

        $eventBus = $this->eventBus();
        $domainEvent = new AccountingCenterCreatedDomainEvent(
            $accountingCenter->id(),
            $accountingCenter->code(),
            $accountingCenter->name(),
            $accountingCenter->description(),
            $accountingCenter->status(),
            $accountingCenter->parentId(),
            $accountingCenter->companyId(),
            $accountingCenter->createdBy(),
            $accountingCenter->updatedBy()
        );
        $this->shouldPublishDomainEvent($domainEvent);

        $creator = new AccountingCenterCreator($repository);

        ($creator)(new AccountingCenterCreatorRequest(
            $accountingCenter->id(),
            $accountingCenter->code(),
            $accountingCenter->name(),
            $accountingCenter->description(),
            $accountingCenter->status(),
            $accountingCenter->parentId(),
            $accountingCenter->companyId(),
            $accountingCenter->createdBy(),
            $accountingCenter->updatedBy()
        ));
    }
}
