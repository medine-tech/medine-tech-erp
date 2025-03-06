<?php

declare(strict_types=1);

namespace MedineTech\Backoffice\Companies\Application\Search;

use MedineTech\Backoffice\Companies\Domain\CompanyRepository;

class CompanySearcher
{
    public function __construct(
        private CompanyRepository $repository
    ) {
    }

    public function __invoke(CompanySearcherRequest $request): CompanySearcherResponse
    {
        $result = $this->repository->search($request->filters());

        return new CompanySearcherResponse($result["items"] ?? []);
    }
}
