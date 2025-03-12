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
        ?string $companyId = null,
        ?int $creatorId = null,
        ?int $updaterId = null
    ): AccountingCenter {
        $faker = Factory::create();

        return new AccountingCenter(
            $id ?? $faker->uuid(),
            $code ?? $faker->uuid(),
            $name ?? $faker->company(),
            $description ?? $faker->optional()->sentence(),
            $status ?? AccountingCenterStatus::ACTIVE,
            $parentId ?? $faker->optional()->uuid(),
            $companyId ?? $faker->uuid(),
                $creatorId ?? $faker->numberBetween(1, 100),
                $updaterId ?? $faker->numberBetween(1, 100)
        );
    }
}
