<?php
// File: `tests/Backoffice/Accounting/AccountingCenter/Domain/AccountingCenterMother.php`
declare(strict_types=1);

namespace Tests\Backoffice\Accounting\AccountingCenter\Domain;

use Faker\Factory;
use MedineTech\Backoffice\Accounting\AccountingCenter\Domain\AccountingCenter;
use MedineTech\Backoffice\Accounting\AccountingCenter\Domain\AccountingCenterStatus;

final class AccountingCenterMother
{
    public static function create(
        ?string $id = null,
        ?string $code = null,
        ?string $name = null,
        ?string $description = null,
        ?string $status = null,
        ?string $parentId = null,
        ?int $creatorId = null,
        ?int $updaterId = null,
        ?string $companyId = null
    ): AccountingCenter {
        $faker = Factory::create();

        $creator = $creatorId ?? $faker->numberBetween(1, 100);

        return new AccountingCenter(
            $id ?? $faker->uuid(),
            $code ?? $faker->uuid(),
            $name ?? $faker->company(),
            $description ?? $faker->optional()->sentence(),
                $status ?? $faker->randomElement([
                AccountingCenterStatus::ACTIVE,
                AccountingCenterStatus::INACTIVE
            ]),
            $parentId ?? $faker->optional()->uuid(),
                $creatorId ?? $creator,
                $updaterId ?? $creator,
                $companyId ?? $faker->uuid()

        );
    }
}
