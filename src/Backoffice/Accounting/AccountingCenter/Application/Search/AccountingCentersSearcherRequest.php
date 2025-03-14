<?php
declare(strict_types=1);

namespace MedineTech\Backoffice\Accounting\AccountingCenter\Application\Search;

final class AccountingCentersSearcherRequest
{
    private array $filters;

    public function __construct(array $filters)
    {
        $this->filters = $filters;
    }

    public function filters(): array
    {
        return $this->filters;
    }
}
