<?php

declare(strict_types=1);

namespace MedineTech\Backoffice\UserRoles\Infrastructure\Persistence;

use App\Models\User;
use MedineTech\Backoffice\UserRoles\Domain\UserRole;
use MedineTech\Backoffice\UserRoles\Domain\UserRoleRepository;

final class EloquentUserRoleRepository implements UserRoleRepository
{
    public function save(UserRole $userRole): void
    {
        // use update or create
        $data = [
            'model_id' => $userRole->userId(),
            'role_id' => $userRole->roleId(),
            'company_id' => $userRole->companyId(),
            "model_type" => User::class
        ];

        UserRoleModel::updateOrCreate([
            'model_id' => $userRole->userId(),
            'role_id' => $userRole->roleId(),
            'company_id' => $userRole->companyId(),
        ], $data);
    }
}
