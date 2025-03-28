<?php
declare(strict_types=1);

namespace Tests\Backoffice\Security\RolePermissions\Domain;

use Faker\Factory;
use MedineTech\Backoffice\Security\RolePermissions\Domain\RolePermission;

class RolePermissionMother
{
    public static function create(
        ?int $roleId = null,
        ?int $permissionId = null
    ): RolePermission {

        $faker = Factory::create();

        return new RolePermission(
            $roleId ?? $faker->randomNumber(),
            $permissionId ?? $faker->randomNumber()
        );
    }
}
