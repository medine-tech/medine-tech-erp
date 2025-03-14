<?php

declare(strict_types=1);

namespace MedineTech\Backoffice\CompanyUsers\Application\Create;

use MedineTech\Backoffice\CompanyUsers\Domain\CompanyUser;
use MedineTech\Backoffice\CompanyUsers\Domain\CompanyUserRepository;
use MedineTech\Shared\Domain\Bus\Event\EventBus;

class CompanyUserCreator
{
    public function __construct(
        private readonly CompanyUserRepository $repository,
        private readonly EventBus $eventBus,
    ) {
    }

    public function __invoke(CompanyUserCreatorRequest $request): void
    {
        $companyUser = CompanyUser::create(
            $request->companyId(),
            $request->userId(),
        );

        $this->repository->save($companyUser);

        $this->eventBus->publish(...$companyUser->pullDomainEvents());
    }
}
