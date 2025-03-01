<?php

declare(strict_types=1);

namespace MedineTech\Backoffice\FirstCompanies\Application\Register;

use MedineTech\Backoffice\FirstCompanies\Domain\FirstCompany;
use MedineTech\Backoffice\FirstCompanies\Domain\FirstCompanyRepository;

final readonly class FirstCompanyRegister
{
    public function __construct(
        private FirstCompanyRepository $repository,
    ) {
    }

    public function __invoke(FirstCompanyRegisterRequest $request): void
    {
        $firstCompany = new FirstCompany(
            $request->userName(),
            $request->userEmail(),
            $request->userPassword(),
        );

        $this->repository->save($firstCompany);
    }
}
