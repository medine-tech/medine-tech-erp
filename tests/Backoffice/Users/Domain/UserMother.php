<?php

declare(strict_types=1);

namespace Tests\Backoffice\Users\Domain;

use Faker\Factory;
use MedineTech\Backoffice\Users\Domain\User;
use MedineTech\Backoffice\Users\Domain\UserEmail;

final class UserMother
{
    public static function create(
        ?int $id = null,
        ?string $name = null,
        ?string $email = null,
        ?string $password = null
    ): User {
        $faker = Factory::create();

        return new User(
            $id ?? $faker->randomNumber(),
            $name ?? $faker->name(),
            new UserEmail($email ?? $faker->email()),
            $password ?? $faker->password()
        );
    }
}
