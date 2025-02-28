<?php

namespace MedineTech\Companies\Infrastructure\Persistence\Eloquent;

use MedineTech\Companies\Domain\Company;
use MedineTech\Companies\Domain\CompanyRepository;

final class EloquentCompanyRepository implements CompanyRepository
{

    public function save(Company $company): void
    {
        try {
            $companyModel = new CompanyModel();
            $companyModel->id = $company->id();
            $companyModel->name = $company->name();

            $companyModel->save();
        } catch (\Exception $e) {
            throw new \RuntimeException("Failed to save company: " . $e->getMessage(), 0, $e);
        }
    }

}
