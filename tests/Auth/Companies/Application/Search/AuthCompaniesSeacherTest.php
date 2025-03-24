<?php

declare(strict_types=1);

namespace Tests\Auth\Companies\Application\Search;

use MedineTech\Auth\Companies\Application\Search\AuthCompaniesSearcher;
use MedineTech\Auth\Companies\Application\Search\AuthCompaniesSearcherRequest;
use MedineTech\Auth\Companies\Domain\AuthCompanyRepository;
use PHPUnit\Framework\Attributes\Test;
use Tests\Auth\Companies\Domain\AuthCompanyMother;
use Tests\Shared\Infrastructure\PhpUnit\UnitTestCase;

final class AuthCompaniesSeacherTest extends UnitTestCase
{
    #[Test]
    public function it_should_search_auth_companies(): void
    {
        $company = AuthCompanyMother::create();
        $filters = ["name" => $company->name(),];

        $companyRepository = $this->mock(AuthCompanyRepository::class);
        $companyRepository->shouldReceive('search')
            ->once()
            ->with($filters)
            ->andReturn([
                "items" => [$company],
                "total" => 1,
                "perPage" => 10,
                "currentPage" => 1,
            ]);

        /** @var AuthCompanyRepository $companyRepository */
        $searcher = new AuthCompaniesSearcher($companyRepository);
        ($searcher)(new AuthCompaniesSearcherRequest($filters));
    }
}
