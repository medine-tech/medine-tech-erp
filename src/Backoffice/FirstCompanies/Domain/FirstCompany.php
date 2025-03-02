<?php

declare(strict_types=1);

namespace MedineTech\Backoffice\FirstCompanies\Domain;

final readonly class FirstCompany
{
    public function __construct(
        private string $userName,
        private string $userEmail,
        private string $userPassword,
    ) {
    }

    public function userName(): string
    {
        return $this->userName;
    }

    public function userEmail(): string
    {
        return $this->userEmail;
    }

    public function userPassword(): string
    {
        return $this->userPassword;
    }
}
