<?php

declare(strict_types=1);

namespace MedineTech\Backoffice\FirstCompanies\Application\Register;

use MedineTech\Backoffice\FirstCompanies\Domain\FirstCompany;
use MedineTech\Backoffice\FirstCompanies\Domain\FirstCompanyRepository;
use MedineTech\Backoffice\Users\Application\Search\UsersSearcher;
use MedineTech\Backoffice\Users\Application\Search\UsersSearcherRequest;

final readonly class FirstCompanyRegister
{
    public function __construct(
        private FirstCompanyRepository $repository,
        private UsersSearcher $usersSearcher
    ) {
    }

    public function __invoke(FirstCompanyRegisterRequest $request): void
    {
        $usersResponse = ($this->usersSearcher)(new UsersSearcherRequest([
            "email" => $request->userEmail(),
        ]));
        $user = $usersResponse->items()[0] ?? null;

        if ($user) {
            return;
        }

        $firstCompany = new FirstCompany(
            $request->userName(),
            $request->userEmail(),
            $request->userPassword(),
        );

        $this->repository->save($firstCompany);
    }
}
