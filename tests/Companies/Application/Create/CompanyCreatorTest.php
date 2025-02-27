<?php

declare(strict_types=1);

namespace Tests\Companies\Application\Create;

use MedineTech\Companies\Application\Create\CompanyCreator;
use MedineTech\Companies\Application\Create\CompanyCreatorRequest;
use MedineTech\Companies\Domain\CompanyRepository;
use PHPUnit\Framework\Attributes\Test;
use Tests\Companies\Domain\CompanyMother;
use Tests\Shared\Infrastructure\PhpUnit\UnitTestCase;

final class CompanyCreatorTest extends UnitTestCase
{
    #[test]
    public function it_should_create_a_company(): void
    {
        $company = CompanyMother::create();

        $companyRepository = $this->mock(CompanyRepository::class);
        $companyRepository->shouldReceive('save')
            ->once()
            ->with($this->similarTo($company))
            ->andReturnNull();


        /* @var CompanyRepository $companyRepository */
        $creator = new CompanyCreator($companyRepository);

        ($creator)(new CompanyCreatorRequest(
            $company->name()
        ));

        $this->assertTrue(true);
    }
}
