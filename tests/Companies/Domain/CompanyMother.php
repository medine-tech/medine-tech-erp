<?php

declare(strict_types=1);

namespace Tests\Companies\Domain;

use Faker\Factory;
use MedineTech\Companies\Domain\Company;

final class CompanyMother
{
    public static function create(
        ?string $id = null,
        ?string $name = null
    ): Company {
        $faker = Factory::create();

        return new Company(
            $id ?? $faker->uuid(),
            $name ?? $faker->name()
        );
    }
}
