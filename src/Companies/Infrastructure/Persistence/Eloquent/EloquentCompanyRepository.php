<?php

namespace MedineTech\Companies\Infrastructure\Persistence\Eloquent;

use MedineTech\Companies\Domain\Company;
use MedineTech\Companies\Domain\CompanyRepository;

final class EloquentCompanyRepository implements CompanyRepository
{

    public function save(Company $company): void
    {
        $companyModel = new CompanyModel();
        $companyModel->name = $company->name();

        $companyModel->save();
    }

}
