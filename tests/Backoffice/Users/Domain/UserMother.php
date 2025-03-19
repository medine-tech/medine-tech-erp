<?php

declare(strict_types=1);

namespace Tests\Backoffice\Users\Domain;

use Faker\Factory;
use MedineTech\Backoffice\Users\Domain\User;

final class UserMother
{
    public static function create(
        ?int $id = null,
        ?string $name = null,
        ?string $email = null,
        ?string $password = null,
        ?string $defaultCompanyId = null
    ): User {
        $faker = Factory::create();

        return User::fromPrimitives([
            "id" => $id ?? $faker->randomNumber(),
            "name" => $name ?? $faker->name(),
            "email" => $email ?? $faker->email(),
            "password" => $password ?? $faker->password(),
            "defaultCompanyId" => $defaultCompanyId ?? $faker->uuid()
        ]);
    }
}
