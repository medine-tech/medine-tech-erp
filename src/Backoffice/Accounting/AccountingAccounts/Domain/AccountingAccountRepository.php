<?php

declare(strict_types=1);

namespace MedineTech\Backoffice\Accounting\AccountingAccounts\Domain;

interface AccountingAccountRepository
{
    public function save(AccountingAccount $accountingAccount): void;
}
