<?php

declare(strict_types=1);

namespace Tests\Auth\Companies\Domain;

use Faker\Factory;
use MedineTech\Auth\Companies\Domain\AuthCompany;

final class AuthCompanyMother
{
    public static function create(
        ?string $id = null,
        ?string $name = null
    ): AuthCompany {
        $faker = Factory::create();

        return new AuthCompany(
            $id ?? $faker->uuid(),
            $name ?? $faker->name()
        );
    }
}
