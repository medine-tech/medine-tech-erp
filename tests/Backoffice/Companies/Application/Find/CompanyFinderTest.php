<?php

declare(strict_types=1);

namespace Tests\Backoffice\Companies\Application\Find;

use MedineTech\Backoffice\Companies\Application\Find\CompanyFinder;
use MedineTech\Backoffice\Companies\Application\Find\CompanyFinderRequest;
use MedineTech\Backoffice\Companies\Domain\CompanyRepository;
use MedineTech\Shared\Domain\ValueObject\Uuid;
use PHPUnit\Framework\Attributes\Test;
use Tests\Backoffice\Companies\CompanyUnitTestCase;
use Tests\Backoffice\Companies\Domain\CompanyMother;


class CompanyFinderTest extends CompanyUnitTestCase
{
    #[test]
    public function it_should_find_a_company()
    {
        $id = Uuid::random()->value();
        $company = CompanyMother::create($id);

        /** @var CompanyRepository $repository */
        $repository = $this->repository();
        $this->shouldFind($company->id(), $company);

        $finder = new CompanyFinder($repository);
        ($finder)(new CompanyFinderRequest($company->id()));
    }
}
