<?php
declare(strict_types=1);

namespace MedineTech\Backoffice\Accounting\AccountingCenter\Application\Update;

use MedineTech\Backoffice\Accounting\AccountingCenter\Domain\AccountingCenterNotFound;
use MedineTech\Backoffice\Accounting\AccountingCenter\Domain\AccountingCenterRepository;

final readonly class AccountingCenterUpdater
{
    public function __construct(
        private AccountingCenterRepository $repository,
    ) {
    }

    public function __invoke(AccountingCenterUpdaterRequest $request): void
    {
        $accountingCenter = $this->repository->find($request->id());
        if ($accountingCenter === null) {
            throw new AccountingCenterNotFound($request->id());
        }

        $accountingCenter->changeName($request->name());
        $accountingCenter->changeDescription($request->description());
        $accountingCenter->changeStatus($request->status());
        $accountingCenter->changeUpdaterId($request->updaterId());
        $accountingCenter->changeParentId($request->parentId());

        $this->repository->save($accountingCenter);
    }
}
