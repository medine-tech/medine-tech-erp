<?php

declare(strict_types=1);

namespace MedineTech\Backoffice\CompanyUsers\Domain;

interface CompanyUserRepository
{
    public function save(CompanyUser $companyUser): void;
}
