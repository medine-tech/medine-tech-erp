<?php

declare(strict_types=1);

namespace MedineTech\Backoffice\FirstCompanies\Application\Register;

use MedineTech\Backoffice\FirstCompanies\Domain\FirstCompany;
use MedineTech\Backoffice\FirstCompanies\Domain\FirstCompanyRepository;
use MedineTech\Backoffice\Users\Application\FindByEmail\UserByEmailFinder;
use MedineTech\Backoffice\Users\Application\FindByEmail\UserByEmailFinderRequest;
use MedineTech\Backoffice\Users\Domain\UserDoesNotExists;

final readonly class FirstCompanyRegister
{
    public function __construct(
        private FirstCompanyRepository $repository,
        private UserByEmailFinder $userByEmailFinder
    ) {
    }

    public function __invoke(FirstCompanyRegisterRequest $request): void
    {
        try {
            $this->ensureUserDoesNotExists($request);
        } catch (UserDoesNotExists) {
            $firstCompany = new FirstCompany(
                $request->userName(),
                $request->userEmail(),
                $request->userPassword(),
            );

            $this->repository->save($firstCompany);
        }
    }

    private function ensureUserDoesNotExists(FirstCompanyRegisterRequest $request): void
    {
        ($this->userByEmailFinder)(new UserByEmailFinderRequest($request->userEmail()));
    }
}
