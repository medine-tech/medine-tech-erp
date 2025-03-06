<?php

declare(strict_types=1);

namespace Companies\Application\Search;

use MedineTech\Backoffice\Companies\Application\Search\CompanySearcher;
use MedineTech\Backoffice\Companies\Application\Search\CompanySearcherRequest;
use MedineTech\Backoffice\Companies\Domain\CompanyRepository;
use PHPUnit\Framework\Attributes\Test;
use Tests\Backoffice\Companies\Domain\CompanyMother;
use Tests\Shared\Infrastructure\PhpUnit\UnitTestCase;

final class CompanySearcherTest extends UnitTestCase
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
        $searcher = new CompanySearcher($companyRepository);
        ($searcher)(new CompanySearcherRequest($filters));
    }
}
