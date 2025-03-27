<?php

declare(strict_types=1);

namespace Tests\Auth\Users\Domain;

use Faker\Factory;
use MedineTech\Auth\Users\Domain\AuthUser;

final class AuthUserMother
{
    public static function create(
        ?int $id = null,
        ?string $name = null,
        ?string $email = null,
        ?string $defaultCompanyId = null
    ): AuthUser {
        $faker = Factory::create();

        return new AuthUser(
            $id ?? $faker->randomNumber(),
            $name ?? $faker->name(),
            $email ?? $faker->email(),
            $defaultCompanyId ?? $faker->uuid()
        );
    }
}
