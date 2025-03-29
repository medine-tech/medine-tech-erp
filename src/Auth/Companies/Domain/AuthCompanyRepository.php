<?php

declare(strict_types=1);

namespace MedineTech\Auth\Companies\Domain;

interface AuthCompanyRepository
{
    /**
     * @param array<string, mixed> $filters
     * @return array{items: array<int, AuthCompany>, total: int, perPage: int, currentPage: int}
     */
    public function search(array $filters): array;
}
