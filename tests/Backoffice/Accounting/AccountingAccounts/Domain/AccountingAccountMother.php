<?php

declare(strict_types=1);

namespace Tests\Backoffice\Accounting\AccountingAccounts\Domain;

use Faker\Factory;
use MedineTech\Backoffice\Accounting\AccountingAccounts\Domain\AccountingAccount;
use MedineTech\Backoffice\Accounting\AccountingAccounts\Domain\AccountingAccountStatus;
use MedineTech\Backoffice\Accounting\AccountingAccounts\Domain\AccountingAccountType;

final class AccountingAccountMother
{
    public static function create(
        ?string $id = null,
        ?string $name = null,
        ?string $code = null,
        ?string $type = null,
        ?string $parentId = null,
        ?string $status = null,
        ?string $companyId = null
    ): AccountingAccount {
        $faker = Factory::create();

        return new AccountingAccount(
            $id ?? $faker->uuid(),
            $name ?? $faker->name(),
            $code ?? $faker->uuid(),
            $type ?? $faker->randomElement([
                AccountingAccountType::ASSET,
                AccountingAccountType::LIABILITY,
                AccountingAccountType::EQUITY,
                AccountingAccountType::REVENUE,
                AccountingAccountType::EXPENSE
            ]),
            $parentId ?? $faker->uuid(),
            $status ?? $faker->randomElement([
                AccountingAccountStatus::ACTIVE,
                AccountingAccountStatus::INACTIVE
            ]),
            $companyId ?? $faker->uuid()
        );
    }
}
