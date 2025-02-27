<?php

declare(strict_types=1);

namespace Tests\Companies\Domain;

use Faker\Factory;
use MedineTech\Companies\Domain\Company;

final class CompanyMother
{
    public static function create(
    ?string $name = null
    ): Company {
        $faker = Factory::create();

        return new Company(
            $name ?? $faker->name()
        );
    }
}
