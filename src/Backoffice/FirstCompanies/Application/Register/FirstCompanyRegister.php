<?php

declare(strict_types=1);

namespace MedineTech\Backoffice\FirstCompanies\Application\Register;

use MedineTech\Backoffice\Companies\Application\Create\CompanyCreator;
use MedineTech\Backoffice\Companies\Application\Create\CompanyCreatorRequest;
use MedineTech\Backoffice\CompanyUsers\Application\Create\CompanyUserCreator;
use MedineTech\Backoffice\CompanyUsers\Application\Create\CompanyUserCreatorRequest;
use MedineTech\Backoffice\Users\Application\Create\UserCreator;
use MedineTech\Backoffice\Users\Application\Create\UserCreatorRequest;

final readonly class FirstCompanyRegister
{
    public function __construct(
        private CompanyCreator $companyCreator,
        private UserCreator $userCreator,
        private CompanyUserCreator $companyUserCreator,
    ) {
    }

    public function __invoke(FirstCompanyRegisterRequest $request): void
    {
        // create user
        $userId = ($this->userCreator)(new UserCreatorRequest(
            $request->userName(),
            $request->userEmail(),
            $request->userPassword(),
        ));

        // create company
        ($this->companyCreator)(new CompanyCreatorRequest(
            $request->companyId(),
            $request->companyName()
        ));

        ($this->companyUserCreator)(new CompanyUserCreatorRequest(
            $request->companyId(),
            $userId,
        ));
    }
}
