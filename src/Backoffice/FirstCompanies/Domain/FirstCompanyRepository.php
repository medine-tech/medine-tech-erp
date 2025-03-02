<?php

declare(strict_types=1);

namespace MedineTech\Backoffice\FirstCompanies\Domain;

interface FirstCompanyRepository
{
    public function save(FirstCompany $firstCompany): void;
}
