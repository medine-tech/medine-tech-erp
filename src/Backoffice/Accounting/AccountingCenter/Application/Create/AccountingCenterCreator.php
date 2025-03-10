<?php

declare(strict_types=1);

namespace MedineTech\Backoffice\Accounting\AccountingCenter\Application\Create;

use MedineTech\Backoffice\Accounting\AccountingCenter\Domain\AccountingCenter;
use MedineTech\Backoffice\Accounting\AccountingCenter\Domain\AccountingCenterRepository;

class AccountingCenterCreator
{
    public function __construct(
        private readonly AccountingCenterRepository $repository
    ) {
    }

    public function __invoke(AccountingCenterCreatorRequest $request): void
    {
        $accountingCenter = AccountingCenter::create(
            $request->id(),
            $request->code(),
            $request->name(),
            $request->description(),
            $request->status(),
            $request->parentId(),
            $request->companyId(),
            $request->createdBy(),
            $request->updatedBy()
        );

        $this->repository->save($accountingCenter);
    }
}
