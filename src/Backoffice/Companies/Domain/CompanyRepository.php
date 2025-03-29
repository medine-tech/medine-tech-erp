<?php

declare(strict_types=1);

namespace MedineTech\Backoffice\Companies\Domain;

interface CompanyRepository
{
    public function save(Company $company): void;

    public function find(string $id): ?Company;

    /**
     * @param array<string, mixed> $filters
     * @param int $perPage
     * @return array{items: array<int, Company>, total: int, perPage: int, currentPage: int}
     */
    public function search(array $filters, int $perPage = 20): array;
}
