<?php

declare(strict_types=1);

namespace MedineTech\Backoffice\Companies\Application\Search;

use MedineTech\Backoffice\Companies\Domain\Company;
use MedineTech\Backoffice\Companies\Domain\CompanyRepository;
use function Lambdish\Phunctional\map;

class CompaniesSearcher
{
    public function __construct(
        private readonly CompanyRepository $repository
    ) {
    }

    public function __invoke(CompaniesSearcherRequest $request): CompaniesSearcherResponse
    {
        $result = $this->repository->search($request->filters());

        return new CompaniesSearcherResponse(
            map(function (Company $company) {
                return new CompanySearcherResponse(
                    $company->id(),
                    $company->name()
                );
            }, $result["items"]),
            $result["total"],
            $result["perPage"],
            $result["currentPage"]
        );
    }
}
