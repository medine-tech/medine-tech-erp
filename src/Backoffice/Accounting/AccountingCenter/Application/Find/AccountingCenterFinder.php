<?php
declare(strict_types=1);

namespace MedineTech\Backoffice\Accounting\AccountingCenter\Application\Find;

use MedineTech\Backoffice\Accounting\AccountingCenter\Domain\AccountingCenterNotFound;
use MedineTech\Backoffice\Accounting\AccountingCenter\Domain\AccountingCenterRepository;

final class AccountingCenterFinder
{
    public function __construct(
        private AccountingCenterRepository $repository
    ) {}

    public function __invoke(AccountingCenterFinderRequest $request): AccountingCenterFinderResponse
    {
        $accountingCenter = $this->repository->find($request->id());
        if ($accountingCenter === null) {
            throw new AccountingCenterNotFound($request->id());
        }

        return new AccountingCenterFinderResponse(
            $accountingCenter->id(),
            $accountingCenter->code(),
            $accountingCenter->name(),
            $accountingCenter->description(),
            $accountingCenter->status(),
            $accountingCenter->parentId(),
            $accountingCenter->creatorId(),
            $accountingCenter->updaterId(),
            $accountingCenter->companyId()
        );
    }
}
