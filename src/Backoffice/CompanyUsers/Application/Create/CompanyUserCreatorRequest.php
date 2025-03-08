<?php

declare(strict_types=1);

namespace MedineTech\Backoffice\CompanyUsers\Application\Create;

final readonly class CompanyUserCreatorRequest
{
    public function __construct(
        private string $companyId,
        private int $userId,
    ) {
    }

    public function companyId(): string
    {
        return $this->companyId;
    }

    public function userId(): int
    {
        return $this->userId;
    }
}
