<?php

declare(strict_types=1);

namespace Tests\Backoffice\FirstCompanies\Application\Register;

use MedineTech\Backoffice\FirstCompanies\Application\Register\FirstCompanyRegister;
use MedineTech\Backoffice\FirstCompanies\Application\Register\FirstCompanyRegisterRequest;
use MedineTech\Backoffice\FirstCompanies\Domain\FirstCompanyRepository;
use PHPUnit\Framework\Attributes\Test;
use Tests\Backoffice\FirstCompanies\Domain\FirstCompanyMother;
use Tests\Shared\Infrastructure\PhpUnit\UnitTestCase;

final class FirstCompanyRegisterTest extends UnitTestCase
{
    #[Test]
    public function it_should_register(): void
    {
        $firstCompany = FirstCompanyMother::create();

        $firstCompanyRepository = $this->mock(FirstCompanyRepository::class);
        $firstCompanyRepository
            ->shouldReceive('save')
            ->once()
            ->with($this->similarTo($firstCompany))
            ->andReturnNull();

        /** @var FirstCompanyRepository $firstCompanyRepository */
        $register = new FirstCompanyRegister($firstCompanyRepository);
        ($register)(new FirstCompanyRegisterRequest(
            $firstCompany->userName(),
            $firstCompany->userEmail(),
            $firstCompany->userPassword(),
        ));
    }
}
