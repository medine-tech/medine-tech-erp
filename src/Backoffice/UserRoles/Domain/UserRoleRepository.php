<?php

declare(strict_types=1);

namespace MedineTech\Backoffice\UserRoles\Domain;

interface UserRoleRepository
{
    public function save(UserRole $userRole): void;
}
