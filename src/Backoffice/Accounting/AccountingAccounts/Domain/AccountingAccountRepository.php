<?php

declare(strict_types=1);

namespace MedineTech\Backoffice\Accounting\AccountingAccounts\Domain;

interface AccountingAccountRepository
{
    public function save(AccountingAccount $accountingAccount): void;

    public function find(string $id): ?AccountingAccount;

    public function search(array $filters): array;
}
