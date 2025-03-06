<?php

declare(strict_types=1);

namespace MedineTech\Backoffice\Companies\Application\Search;

use MedineTech\Backoffice\Companies\Domain\CompanyRepository;

class CompaniesSearcher
{
    public function __construct(
        private CompanyRepository $repository
    ) {
    }

    public function __invoke(CompaniesSearcherRequest $request): CompaniesSearcherResponse
    {
        $result = $this->repository->search($request->filters());

        return new CompaniesSearcherResponse($result["items"] ?? []);
    }
}
