<?php

declare(strict_types=1);

namespace MedineTech\Auth\Companies\Application\Search;

use MedineTech\Auth\Companies\Domain\AuthCompany;
use MedineTech\Auth\Companies\Domain\AuthCompanyRepository;
use function Lambdish\Phunctional\map;

class AuthCompaniesSearcher
{
    public function __construct(
        private readonly AuthCompanyRepository $repository
    ) {
    }

    public function __invoke(AuthCompaniesSearcherRequest $request): AuthCompaniesSearcherResponse
    {
        $result = $this->repository->search($request->filters());

        return new AuthCompaniesSearcherResponse(
            map(function (AuthCompany $authCompany) {
                return new AuthCompanySearcherResponse(
                    $authCompany->id(),
                    $authCompany->name()
                );
            }, $result["items"]),
            $result["total"],
            $result["perPage"],
            $result["currentPage"]
        );
    }
}
