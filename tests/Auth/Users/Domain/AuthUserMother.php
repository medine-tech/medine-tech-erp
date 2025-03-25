<?php

declare(strict_types=1);

namespace Tests\Auth\Users\Domain;

use Faker\Factory;
use MedineTech\Auth\Users\Domain\AuthUser;

final class AuthUserMother
{
    public static function create(
        ?string $id = null,
        ?string $name = null,
        ?string $email = null,
        ?string $password = null,
        ?string $defaultCompanyId = null
    ): AuthUser {
        $faker = Factory::create();

        return new AuthUser(
            (string)$id ?? $faker->uuid(),
            $name ?? $faker->name(),
            $email ?? $faker->email(),
            $password ?? $faker->password(),
            $defaultCompanyId ?? $faker->uuid()
        );
    }
}
