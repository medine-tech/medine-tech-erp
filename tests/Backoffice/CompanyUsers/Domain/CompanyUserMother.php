<?php

declare(strict_types=1);

namespace Tests\Backoffice\CompanyUsers\Domain;

use Faker\Factory;
use MedineTech\Backoffice\CompanyUsers\Domain\CompanyUser;

final class CompanyUserMother
{
    public static function create(
        ?string $companyId = null,
        ?int $userId = null,
    ): CompanyUser {
        $fake = Factory::create();

        return new CompanyUser(
            $companyId ?? $fake->uuid(),
            $userId ?? $fake->randomNumber(5),
        );
    }
}
