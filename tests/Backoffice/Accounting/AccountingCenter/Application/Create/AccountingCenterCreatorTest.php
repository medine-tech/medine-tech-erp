<?php
declare(strict_types=1);

namespace Tests\Backoffice\Accounting\AccountingCenter\Application\Create;

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

        $repository = $this->mock(AccountingCenterRepository::class);
        $repository->shouldReceive('save')
            ->once()
            ->with($this->similarTo($accountingCenter))
            ->andReturnNull();

        $defaultStatus = 'active';
        $domainEvent = new AccountingCenterCreatedDomainEvent(
            $accountingCenter->id(),
            $accountingCenter->code(),
            $accountingCenter->name(),
            $accountingCenter->description(),
            $defaultStatus,
            $accountingCenter->parentId(),
            $accountingCenter->companyId(),
            $accountingCenter->creatorId(),
            $accountingCenter->updaterId()
        );

        $this->shouldPublishDomainEvent($domainEvent);

        $eventBus = $this->eventBus();

        $creator = new AccountingCenterCreator($repository, $eventBus);

        ($creator)(new AccountingCenterCreatorRequest(
            $accountingCenter->id(),
            $accountingCenter->code(),
            $accountingCenter->name(),
            $accountingCenter->description(),
            $accountingCenter->parentId(),
            $accountingCenter->companyId(),
            $accountingCenter->creatorId(),
            $accountingCenter->updaterId()
        ));
    }
}
