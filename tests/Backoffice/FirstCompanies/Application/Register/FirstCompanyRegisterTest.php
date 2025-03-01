<?php

declare(strict_types=1);

namespace Tests\Backoffice\FirstCompanies\Application\Register;

use MedineTech\Backoffice\FirstCompanies\Application\Register\FirstCompanyRegister;
use MedineTech\Backoffice\FirstCompanies\Application\Register\FirstCompanyRegisterRequest;
use MedineTech\Backoffice\FirstCompanies\Domain\FirstCompanyRepository;
use MedineTech\Backoffice\Users\Application\FindByEmail\UserByEmailFinder;
use MedineTech\Backoffice\Users\Application\FindByEmail\UserByEmailFinderRequest;
use MedineTech\Backoffice\Users\Application\FindByEmail\UserByEmailFinderResponse;
use MedineTech\Backoffice\Users\Domain\UserDoesNotExists;
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

        $userByEmailFinder = $this->mock(UserByEmailFinder::class);
        $userByEmailFinder->shouldReceive('__invoke')
            ->once()
            ->with($this->similarTo(new UserByEmailFinderRequest(
                $firstCompany->userEmail(),
            )))
            ->andThrow(UserDoesNotExists::class);


        /** @var FirstCompanyRepository $firstCompanyRepository */
        /** @var UserByEmailFinder $userByEmailFinder */
        $register = new FirstCompanyRegister(
            $firstCompanyRepository,
            $userByEmailFinder,
        );
        ($register)(new FirstCompanyRegisterRequest(
            $firstCompany->userName(),
            $firstCompany->userEmail(),
            $firstCompany->userPassword(),
        ));
    }
}
