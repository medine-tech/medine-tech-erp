<?php

declare(strict_types=1);

namespace Tests\Backoffice\Accounting\AccountingCenter\Domain;

use Faker\Factory;
use MedineTech\Backoffice\Accounting\AccountingCenter\Domain\AccountingCenter;

final class AccountingCenterMother
{
    public static function create(
        ?string $id = null,
        ?string $code = null,
        ?string $name = null,
        ?string $description = null,
        ?int $status = null,
        ?string $parentId = null,
        ?string $companyId = null,
        ?string $createdBy = null,
        ?string $updatedBy = null
    ): AccountingCenter {
        $faker = Factory::create();

        return new AccountingCenter(
            $id ?? $faker->uuid(),
            $code ?? $faker->uuid(),
            $name ?? $faker->company(),
            $description ?? $faker->optional()->sentence(),
            $status ?? $faker->randomElement([1, 0]),
            $parentId ?? $faker->optional()->uuid(),
            $companyId ?? $faker->uuid(),
            $createdBy ?? $faker->uuid(),
            $updatedBy ?? $faker->uuid()
        );
    }
}
