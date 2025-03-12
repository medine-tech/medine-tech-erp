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
        ?string $code = null,
        ?string $name = null,
        ?string $description = null,
        ?int $type = null,
        ?string $status = null,
        ?string $parentId = null,
        ?int $creatorId = null,
        ?int $updaterId = null,
        ?string $companyId = null
    ): AccountingAccount {
        $faker = Factory::create();

        return new AccountingAccount(
            $id ?? $faker->uuid(),
                $code ?? $faker->uuid(),
            $name ?? $faker->name(),
            $description ?? $faker->text(),
            $type ?? $faker->randomElement([
                AccountingAccountType::ASSET,
                AccountingAccountType::LIABILITY,
                AccountingAccountType::EQUITY,
                AccountingAccountType::REVENUE,
                AccountingAccountType::EXPENSE
            ]),
                $status ?? AccountingAccountStatus::ACTIVE,
            $parentId ?? $faker->uuid(),
                $creatorId ?? $faker->numberBetween(1, 100),
                $updaterId ?? $faker->numberBetween(1, 100),
            $companyId ?? $faker->uuid()

        );
    }
}
