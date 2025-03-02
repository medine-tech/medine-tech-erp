<?php

declare(strict_types=1);

namespace Tests\Backoffice\FirstCompanies\Domain;

use Faker\Factory;
use MedineTech\Backoffice\FirstCompanies\Domain\FirstCompany;

final class FirstCompanyMother
{
    public static function create(
        ?string $userName = null,
        ?string $userEmail = null,
        ?string $userPassword = null,
    ): FirstCompany {
        $faker = Factory::create();

        return new FirstCompany(
            $userName ?? $faker->userName(),
            $userEmail ?? $faker->email(),
            $userPassword ?? $faker->password(),
        );
    }
}
