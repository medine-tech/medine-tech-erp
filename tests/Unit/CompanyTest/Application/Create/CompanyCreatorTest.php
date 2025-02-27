<?php

declare(strict_types=1);

namespace Tests\Unit\CompanyTest\Application\Create;

use MedineTech\Companies\Application\Create\CompanyCreator;
use MedineTech\Companies\Application\Create\CompanyCreatorRequest;
use MedineTech\Companies\Domain\CompanyRepository;
use Tests\Unit\CompanyTest\Domain\CompanyMother;

final class CompanyCreatorTest extends UnitTestCase
{
    /**
     * @test
     */
    public function it_should_create_a_company(): void
    {
        $company = CompanyMother::create();

        $companyRepository = $this->mock(CompanyRepository::class);
        $companyRepository->shouldReceive('save')
            ->once()
            ->with($company)
            ->andReturnNull();


        /* @var CompanyRepository $companyRepository */
        $creator = new CompanyCreator($companyRepository);

        ($creator)(new CompanyCreatorRequest(
            $company->id(),
            $company->data()
        ));
    }
}
