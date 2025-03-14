<?php

declare(strict_types=1);

namespace MedineTech\Backoffice\CompanyUsers\Infrastructure\Persistence\Eloquent;

use MedineTech\Backoffice\CompanyUsers\Domain\CompanyUser;
use MedineTech\Backoffice\CompanyUsers\Domain\CompanyUserRepository;

final class EloquentCompanyUserRepository implements CompanyUserRepository
{
    public function save(CompanyUser $companyUser): void
    {
        CompanyUserModel::updateOrCreate(
            [
                'company_id' => $companyUser->companyId(),
                'user_id' => $companyUser->userId(),
            ],
            [
                'company_id' => $companyUser->companyId(),
                'user_id' => $companyUser->userId(),
            ]
        );
    }
}
