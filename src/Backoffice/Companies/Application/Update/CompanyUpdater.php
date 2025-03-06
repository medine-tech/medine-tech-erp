<?php

declare(strict_types=1);

namespace MedineTech\Backoffice\Companies\Application\Update;

use MedineTech\Backoffice\Companies\Domain\CompanyNotFound;
use MedineTech\Backoffice\Companies\Domain\CompanyRepository;

final readonly class CompanyUpdater
{
    public function __construct(
        private CompanyRepository $repository
    )
    {
    }

    public function __invoke(CompanyUpdaterRequest $request): void
    {
        $company = $this->repository->find($request->id());

        if ($company === null) {
            throw new CompanyNotFound($request->id());
        }

        $company->changeName($request->name());

        $this->repository->save($company);
    }

}
