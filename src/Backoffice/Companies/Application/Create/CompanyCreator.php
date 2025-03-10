<?php

declare(strict_types=1);

namespace MedineTech\Backoffice\Companies\Application\Create;

use MedineTech\Backoffice\Companies\Domain\Company;
use MedineTech\Backoffice\Companies\Domain\CompanyRepository;
use MedineTech\Backoffice\CompanyUsers\Application\Create\CompanyUserCreator;
use MedineTech\Backoffice\CompanyUsers\Application\Create\CompanyUserCreatorRequest;
use MedineTech\Shared\Domain\Bus\Event\EventBus;

class CompanyCreator
{
    public function __construct(
        private readonly CompanyRepository $repository,
        private readonly CompanyUserCreator $companyUserCreator,
        private readonly EventBus $eventBus
    ) {
    }

    public function __invoke(CompanyCreatorRequest $request): void
    {
        $company = Company::create(
            $request->id(),
            $request->name()
        );

        $this->repository->save($company);

        ($this->companyUserCreator)(new CompanyUserCreatorRequest(
            $company->id(),
            $request->userId()
        ));

        $this->eventBus->publish(...$company->pullDomainEvents());
    }

}
