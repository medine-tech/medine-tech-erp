<?php

declare(strict_types=1);

namespace MedineTech\Backoffice\Companies\Application\Find;

use MedineTech\Backoffice\Companies\Domain\CompanyNotFound;
use MedineTech\Backoffice\Companies\Domain\CompanyRepository;

final readonly class CompanyFinder
{
    public function __construct(
        private readonly CompanyRepository $repository
    )
    {
    }

    public function __invoke(CompanyFinderRequest $request): CompanyFinderResponse
    {
        $company = $this->repository->find($request->id());

        if (null === $company) {
            throw new CompanyNotFound($request->id());
        }

        return new CompanyFinderResponse(
            $company->id(),
            $company->name()
        );
    }
}
