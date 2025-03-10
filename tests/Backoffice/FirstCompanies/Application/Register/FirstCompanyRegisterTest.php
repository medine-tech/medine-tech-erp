<?php

declare(strict_types=1);

namespace Tests\Backoffice\FirstCompanies\Application\Register;

use MedineTech\Backoffice\Companies\Application\Create\CompanyCreator;
use MedineTech\Backoffice\Companies\Application\Create\CompanyCreatorRequest;
use MedineTech\Backoffice\CompanyUsers\Application\Create\CompanyUserCreator;
use MedineTech\Backoffice\CompanyUsers\Application\Create\CompanyUserCreatorRequest;
use MedineTech\Backoffice\FirstCompanies\Application\Register\FirstCompanyRegister;
use MedineTech\Backoffice\FirstCompanies\Application\Register\FirstCompanyRegisterRequest;
use MedineTech\Backoffice\Users\Application\Create\UserCreator;
use MedineTech\Backoffice\Users\Application\Create\UserCreatorRequest;
use PHPUnit\Framework\Attributes\Test;
use Tests\Shared\Infrastructure\PhpUnit\UnitTestCase;

final class FirstCompanyRegisterTest extends UnitTestCase
{
    #[Test]
    public function it_should_register(): void
    {
        $companyId = "company-id";
        $request = new FirstCompanyRegisterRequest(
            $companyId,
            "company-name",
            "user-name",
            "user-email",
            "user-password",
        );

        // create user
        $userId = 1;
        $userCreator = $this->mock(UserCreator::class);
        $userCreator->shouldReceive('__invoke')
            ->once()
            ->with($this->similarTo(new UserCreatorRequest(
                $request->userName(),
                $request->userEmail(),
                $request->userPassword(),
                $companyId
            )))
            ->andReturn($userId);

        // create company
        $companyCreator = $this->mock(CompanyCreator::class);
        $companyCreator->shouldReceive('__invoke')
            ->once()
            ->with($this->similarTo(new CompanyCreatorRequest(
                $request->companyId(),
                $request->companyName(),
                $userId
            )))
            ->andReturnNull();

        // user company creator
        $companyUserCreator = $this->mock(CompanyUserCreator::class);
        $companyUserCreator->shouldReceive('__invoke')
            ->once()
            ->with($this->similarTo(new CompanyUserCreatorRequest(
                $request->companyId(),
                $userId,
            )))
            ->andReturnNull();

        /** @var CompanyCreator $companyCreator */
        /** @var UserCreator $userCreator */
        /** @var CompanyUserCreator $companyUserCreator */
        $register = new FirstCompanyRegister(
            $companyCreator,
            $userCreator,
            $companyUserCreator
        );
        ($register)(new FirstCompanyRegisterRequest(
            $request->companyId(),
            $request->companyName(),
            $request->userName(),
            $request->userEmail(),
            $request->userPassword(),
        ));
    }
}
