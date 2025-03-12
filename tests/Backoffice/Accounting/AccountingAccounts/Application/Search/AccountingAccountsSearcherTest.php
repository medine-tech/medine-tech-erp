<?php

declare(strict_types=1);

namespace Tests\Backoffice\Accounting\AccountingAccounts\Application\Search;

use MedineTech\Backoffice\Accounting\AccountingAccounts\Application\Search\AccountingAccountsSearcher;
use MedineTech\Backoffice\Accounting\AccountingAccounts\Application\Search\AccountingAccountsSearcherRequest;
use MedineTech\Backoffice\Accounting\AccountingAccounts\Domain\AccountingAccountRepository;
use PHPUnit\Framework\Attributes\Test;
use Tests\Backoffice\Accounting\AccountingAccounts\Domain\AccountingAccountMother;
use Tests\Shared\Infrastructure\PhpUnit\UnitTestCase;

final class AccountingAccountsSearcherTest extends UnitTestCase
{
    #[Test]
    public function it_should_search_accounting_accounts(): void
    {
        $accountingAccount = AccountingAccountMother::create();
        $filters = ["id" => $accountingAccount->id(),];

        $accountingAccountRepository = $this->mock(AccountingAccountRepository::class);
        $accountingAccountRepository->shouldReceive('search')
            ->once()
            ->with($filters)
            ->andReturn([
                "items" => [$accountingAccount],
                "total" => 1,
                "perPage" => 10,
                "currentPage" => 1,
            ]);

        /** @var AccountingAccountRepository $accountingAccountRepository */
        $searcher = new AccountingAccountsSearcher($accountingAccountRepository);
        ($searcher)(new AccountingAccountsSearcherRequest($filters));
    }
}
