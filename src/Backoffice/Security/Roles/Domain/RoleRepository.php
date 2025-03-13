<?php

declare(strict_types=1);

namespace MedineTech\Backoffice\Security\Roles\Domain;

interface RoleRepository
{
    public function save(Role $role): void;

    public function nextCode(string $company_id): string;
}
