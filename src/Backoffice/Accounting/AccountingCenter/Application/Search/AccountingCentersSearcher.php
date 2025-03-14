<?php
declare(strict_types=1);

namespace MedineTech\Backoffice\Accounting\AccountingCenter\Application\Search;

use MedineTech\Backoffice\Accounting\AccountingCenter\Domain\AccountingCenter;
use MedineTech\Backoffice\Accounting\AccountingCenter\Domain\AccountingCenterRepository;
use function Lambdish\Phunctional\map;

class AccountingCentersSearcher
{
    public function __construct(
        private AccountingCenterRepository $repository
    ) {
    }

    public function __invoke(AccountingCentersSearcherRequest $request): AccountingCentersSearcherResponse
    {
        $result = $this->repository->search($request->filters());

        $items = map(function (AccountingCenter $accountingCenter) {
            return new AccountingCenterSearcherResponse(
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
        }, $result["items"]);

        return new AccountingCentersSearcherResponse(
            $items,
            $result["total"],
            $result["perPage"],
            $result["currentPage"]
        );
    }
}
