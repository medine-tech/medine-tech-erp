<?php

declare(strict_types=1);

namespace Tests\Backoffice\UserRoles\Domain;

use Faker\Factory;
use MedineTech\Backoffice\UserRoles\Domain\UserRole;

final class UserRoleMother
{
    public static function create(
        ?int $userId = null,
        ?int $roleId = null,
        ?string $companyId = null
    ): UserRole {
        $faker = Factory::create();

        return new UserRole(
            $userId ?? $faker->randomNumber(),
            $roleId ?? $faker->randomNumber(),
            $companyId ?? $faker->uuid()
        );
    }
}
