<?php

declare(strict_types=1);

namespace MedineTech\Backoffice\Security\Roles\Domain;

interface RoleRepository
{
    public function save(Role $role): int;

    public function find(int $id): ?Role;

    public function search(array $filters): array;

    public function nextCode(string $company_id): string;
}
