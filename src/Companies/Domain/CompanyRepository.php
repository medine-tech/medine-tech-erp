<?php

declare(strict_types=1);

namespace MedineTech\Companies\Domain;

interface CompanyRepository
{
    public function save(Company $company): void;

    public function find(string $id): ?Company;
}
