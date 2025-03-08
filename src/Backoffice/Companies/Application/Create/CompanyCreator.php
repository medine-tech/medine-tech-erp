<?php

declare(strict_types=1);

namespace MedineTech\Backoffice\Companies\Application\Create;

use MedineTech\Backoffice\Companies\Domain\Company;
use MedineTech\Backoffice\Companies\Domain\CompanyRepository;

final class CompanyCreator
{
    public function __construct(
        private readonly CompanyRepository $repository
    )
    {
    }

    public function __invoke(CompanyCreatorRequest $request): void
    {
        $company = Company::create(
            $request->id(),
            $request->name()
        );

        $this->repository->save($company);
    }

}
