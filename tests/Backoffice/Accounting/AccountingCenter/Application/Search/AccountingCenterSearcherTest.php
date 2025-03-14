<?php
declare(strict_types=1);

namespace Tests\Backoffice\Accounting\AccountingCenter\Application\Search;

use MedineTech\Backoffice\Accounting\AccountingCenter\Application\Search\AccountingCentersSearcher;
use MedineTech\Backoffice\Accounting\AccountingCenter\Application\Search\AccountingCentersSearcherRequest;
use MedineTech\Backoffice\Accounting\AccountingCenter\Domain\AccountingCenterRepository;
use PHPUnit\Framework\Attributes\Test;
use Tests\Backoffice\Accounting\AccountingCenter\Domain\AccountingCenterMother;
use Tests\Shared\Infrastructure\PhpUnit\UnitTestCase;

final class AccountingCenterSearcherTest extends UnitTestCase
{
    #[Test]
    public function it_should_search_accounting_centers(): void
    {
        $accountingCenter = AccountingCenterMother::create();
        $filters = ['id' => $accountingCenter->id()];

        $accountingCenterRepository = $this->mock(AccountingCenterRepository::class);
        $accountingCenterRepository->shouldReceive('search')
            ->once()
            ->with($filters)
            ->andReturn([
                'items' => [$accountingCenter],
                'total' => 1,
                'perPage' => 10,
                'currentPage' => 1,
            ]);

        /** @var AccountingCenterRepository $accountingCenterRepository */
        $searcher = new AccountingCentersSearcher($accountingCenterRepository);
        ($searcher)(new AccountingCentersSearcherRequest($filters));
    }
}
