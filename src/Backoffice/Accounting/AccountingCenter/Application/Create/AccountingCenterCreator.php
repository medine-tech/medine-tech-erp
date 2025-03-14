<?php
declare(strict_types=1);

namespace MedineTech\Backoffice\Accounting\AccountingCenter\Application\Create;

use MedineTech\Backoffice\Accounting\AccountingCenter\Domain\AccountingCenter;
use MedineTech\Backoffice\Accounting\AccountingCenter\Domain\AccountingCenterRepository;
use MedineTech\Shared\Domain\Bus\Event\EventBus;

class AccountingCenterCreator
{
    public function __construct(
        private readonly AccountingCenterRepository $repository,
        private readonly EventBus                   $eventBus
    )
    {
    }

    public function __invoke(AccountingCenterCreatorRequest $request): void
    {
        $accountingCenter = AccountingCenter::create(
            $request->id(),
            $request->code(),
            $request->name(),
            $request->description(),
            $request->parentId(),
            $request->creatorId(),
            $request->companyId()
        );

        $this->repository->save($accountingCenter);

        $this->eventBus->publish(...$accountingCenter->pullDomainEvents());
    }
}
