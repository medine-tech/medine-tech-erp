<?php

declare(strict_types=1);

namespace MedineTech\Backoffice\Security\Roles\Domain;

interface RoleRepository
{
    public function save(Role $role): int;

    public function find(int $id): ?Role;

    /**
     * @param array<string, mixed> $filters
     * @return array{items: array<int, Role>, total: int, perPage: int, currentPage: int}
     */
    public function search(array $filters): array;

    public function nextCode(string $company_id): string;
}
