<?php

declare(strict_types=1);

namespace MedineTech\Backoffice\Accounting\AccountingCenter\Domain;

interface AccountingCenterRepository
{
    public function save(AccountingCenter $accountingCenter): void;

    public function find(string $id): ?AccountingCenter;

    public function search(array $filters): array;
}
