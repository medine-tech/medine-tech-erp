<?php

declare(strict_types=1);

namespace MedineTech\Backoffice\Accounting\AccountingCenter\Domain;

interface AccountingCenterRepository
{
    public function save(AccountingCenter $accountingCenter): void;

    public function find(string $id): ?AccountingCenter;

    /**
     * @param array<string, mixed> $filters
     * @return array{items: array<int, AccountingCenter>, total: int, perPage: int, currentPage: int}
     */
    public function search(array $filters): array;
}
