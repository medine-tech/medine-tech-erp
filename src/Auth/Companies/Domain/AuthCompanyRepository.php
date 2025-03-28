<?php

declare(strict_types=1);

namespace MedineTech\Auth\Companies\Domain;

interface AuthCompanyRepository
{
    public function search(array $filters): array;
}
