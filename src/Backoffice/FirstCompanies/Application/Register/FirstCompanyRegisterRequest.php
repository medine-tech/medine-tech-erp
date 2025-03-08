<?php

declare(strict_types=1);

namespace MedineTech\Backoffice\FirstCompanies\Application\Register;

final readonly class FirstCompanyRegisterRequest
{
    public function __construct(
        private string $companyId,
        private string $companyName,
        private string $userName,
        private string $userEmail,
        private string $userPassword,
    ) {
    }

    public function companyId(): string
    {
        return $this->companyId;
    }

    public function companyName(): string
    {
        return $this->companyName;
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
