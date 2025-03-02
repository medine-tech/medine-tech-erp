<?php

declare(strict_types=1);

namespace MedineTech\Backoffice\FirstCompanies\Infrastructure\Persistence\Eloquent;

use App\Models\User;
use MedineTech\Backoffice\FirstCompanies\Domain\FirstCompany;
use MedineTech\Backoffice\FirstCompanies\Domain\FirstCompanyRepository;

final class EloquentFirstCompanyRepository implements FirstCompanyRepository
{
    public function save(FirstCompany $firstCompany): void
    {
        User::create([
            'name' => $firstCompany->userName(),
            'email' => $firstCompany->userEmail(),
            'password' => $firstCompany->userPassword(),
        ]);
    }
}
