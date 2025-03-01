<?php

declare(strict_types=1);

namespace Tests\UserTest\Domain;

use MedineTech\Users\Domain\User;
use Faker\Factory;

final class UserMother
{
    public static function create(
        ?string $name = null,
        ?string $email = null,
        ?string $password = null
    ): User {
        $faker = Factory::create();

        return User::create(
            $name ?? $faker->name(),
            $email ?? $faker->email(),
            $password ?? $faker->password()
        );
    }
}
