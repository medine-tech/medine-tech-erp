<?php

declare(strict_types=1);

namespace Tests\Unit\CompanyTest\Domain;

use Faker\Factory;
use MedineTech\Companies\Domain\Company;

final class CompanyMother
{
    public static function create(
    ?string $id = null,
    ?array $data = null
    ): Company {
        $faker = Factory::create();

        return new Company(
            $id ?? $faker->uuid(),
            $data ?? []
        );
    }
}
