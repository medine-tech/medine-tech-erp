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
        ?int $companyId = null,
        ?int $updaterId = null,
        ?string $guardName = null,
    ): Role {
        $faker = Factory::create();

        $userId = $faker->randomNumber();

        $status = $status ?? $faker->randomElement([
            RoleStatus::ACTIVE,
            RoleStatus::INACTIVE
        ]);

        $guardName = 'sanctum';

        return new Role(
            $id,
            $code ?? "ROL25000001",
            $name ?? $faker->name(),
            $description ?? $faker->text(),
            $status ?? $status,
            $creatorId ?? $userId,
            $updaterId ?? $userId,
            $companyId ?? $faker->uuid(),
            $guardName ?? $guardName
        );
    }
}
