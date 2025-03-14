<?php
declare(strict_types=1);

namespace Tests\Backoffice\Accounting\AccountingCenter\Application\Find;

use MedineTech\Backoffice\Accounting\AccountingCenter\Application\Find\AccountingCenterFinder;
use MedineTech\Backoffice\Accounting\AccountingCenter\Application\Find\AccountingCenterFinderRequest;
use MedineTech\Backoffice\Accounting\AccountingCenter\Domain\AccountingCenterRepository;
use MedineTech\Shared\Domain\ValueObject\Uuid;
use PHPUnit\Framework\Attributes\Test;
use Tests\Backoffice\Accounting\AccountingCenter\AccountingCenterUnitTestCase;
use Tests\Backoffice\Accounting\AccountingCenter\Domain\AccountingCenterMother;

final class AccountingCenterFinderTest extends AccountingCenterUnitTestCase
{
    #[Test]
    public function it_should_find_an_accounting_center(): void
    {
        $id = Uuid::random()->value();
        $accountingCenter = AccountingCenterMother::create($id);

        /** @var AccountingCenterRepository $repository */
        $repository = $this->repository();
        $this->shouldFind($accountingCenter->id(), $accountingCenter);

        $finder = new AccountingCenterFinder($repository);
        ($finder)(new AccountingCenterFinderRequest($accountingCenter->id()));
    }
}
