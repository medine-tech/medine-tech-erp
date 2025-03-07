<?php

declare(strict_types=1);

namespace Tests\Backoffice\Companies\Application\Create;

use MedineTech\Backoffice\Companies\Application\Create\CompanyCreator;
use MedineTech\Backoffice\Companies\Application\Create\CompanyCreatorRequest;
use MedineTech\Backoffice\Companies\Domain\CompanyRepository;
use PHPUnit\Framework\Attributes\Test;
use Tests\Backoffice\Companies\Domain\CompanyMother;
use Tests\Shared\Infrastructure\PhpUnit\UnitTestCase;

final class CompanyCreatorTest extends UnitTestCase
{
    #[Test]
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
            $company->id(),
            $company->name()
        ));
    }
}
