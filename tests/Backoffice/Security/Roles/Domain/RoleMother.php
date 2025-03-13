<?php

declare(strict_types=1);

namespace Tests\Backoffice\Security\Roles\Domain;

use Faker\Factory;
use MedineTech\Backoffice\Security\Roles\Domain\Role;
use MedineTech\Backoffice\Security\Roles\Domain\RoleStatus;

final class RoleMother
{
    public static function create(
        ?int $id = null,
        ?string $code = null,
        ?string $name = null,
        ?string $description = null,
        ?string $status = null,
        ?int $creatorId = null,
        ?int $companyId = null
    ): Role {
        $faker = Factory::create();

        $userId = $faker->randomNumber();

        $status = $status ?? $faker->randomElement([
            RoleStatus::ACTIVE,
            RoleStatus::INACTIVE
        ]);

        return new Role(
            $id ?? $faker->randomNumber(),
            $code ?? $faker->uuid(),
            $name ?? $faker->name(),
            $description ?? $faker->text(),
            $status,
            $creatorId ?? $userId,
            $updaterId ?? $userId,
            $companyId ?? $faker->uuid()
        );
    }
}
