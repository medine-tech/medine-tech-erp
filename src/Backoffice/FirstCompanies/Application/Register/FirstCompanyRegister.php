<?php

declare(strict_types=1);

namespace MedineTech\Backoffice\FirstCompanies\Application\Register;

use MedineTech\Backoffice\Companies\Application\Create\CompanyCreator;
use MedineTech\Backoffice\Companies\Application\Create\CompanyCreatorRequest;
use MedineTech\Backoffice\CompanyUsers\Application\Create\CompanyUserCreator;
use MedineTech\Backoffice\CompanyUsers\Application\Create\CompanyUserCreatorRequest;
use MedineTech\Backoffice\Security\Roles\Application\Create\RoleCreator;
use MedineTech\Backoffice\Security\Roles\Application\Create\RoleCreatorRequest;
use MedineTech\Backoffice\Users\Application\Create\UserCreator;
use MedineTech\Backoffice\Users\Application\Create\UserCreatorRequest;

final readonly class FirstCompanyRegister
{
    public function __construct(
        private CompanyCreator $companyCreator,
        private UserCreator $userCreator,
        private CompanyUserCreator $companyUserCreator,
        private RoleCreator $roleCreator
    ) {
    }

    public function __invoke(FirstCompanyRegisterRequest $request): void
    {
        // create user
        $userId = ($this->userCreator)(new UserCreatorRequest(
            $request->userName(),
            $request->userEmail(),
            $request->userPassword(),
            $request->companyId()
        ));

        // create company
        ($this->companyCreator)(new CompanyCreatorRequest(
            $request->companyId(),
            $request->companyName(),
            $userId
        ));

        ($this->companyUserCreator)(new CompanyUserCreatorRequest(
            $request->companyId(),
            $userId,
        ));

        $roleId = ($this->roleCreator)(new RoleCreatorRequest(
            "Super-Admin",
            "Super admin role",
            $userId,
            $request->companyId()
        ));
    }
}
