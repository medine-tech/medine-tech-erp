<?php

declare(strict_types=1);

namespace Tests\Backoffice\Companies\Application\Search;

use MedineTech\Backoffice\Companies\Application\Search\CompaniesSearcher;
use MedineTech\Backoffice\Companies\Application\Search\CompaniesSearcherRequest;
use MedineTech\Backoffice\Companies\Domain\CompanyRepository;
use PHPUnit\Framework\Attributes\Test;
use Tests\Backoffice\Companies\Domain\CompanyMother;
use Tests\Shared\Infrastructure\PhpUnit\UnitTestCase;

final class CompaniesSearcherTest extends UnitTestCase
{
    #[test]
    public function it_should_search_companies(): void
    {
        $company = CompanyMother::create();
        $filters = ["name" => $company->name(),];

        $companyRepository = $this->mock(CompanyRepository::class);
        $companyRepository->shouldReceive('search')
            ->once()
            ->with($filters)
            ->andReturn([$company]);

        /** @var CompanyRepository $companyRepository */
        $searcher = new CompaniesSearcher($companyRepository);
        $response = ($searcher)(new CompaniesSearcherRequest($filters));

        $this->assertEquals([$company], $response->items());
    }
}
