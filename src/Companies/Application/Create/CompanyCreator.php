<?php

declare(strict_types=1);

namespace MedineTech\Companies\Application\Create;

use MedineTech\Companies\Domain\Company;
use MedineTech\Companies\Domain\CompanyRepository;

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
            $request->data()
        );

        $this->repository->save($company);
    }

}
