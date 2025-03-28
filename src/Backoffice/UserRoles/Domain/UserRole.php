<?php

declare(strict_types=1);

namespace MedineTech\Backoffice\UserRoles\Domain;

final readonly class UserRole
{
    public function __construct(
        private int $userId,
        private int $roleId,
        private string $companyId
    ) {
    }

    public static function create(
        int $userId,
        int $roleId,
        string $companyId
    ): UserRole {
        return new self($userId, $roleId, $companyId);
    }

    public function userId(): int
    {
        return $this->userId;
    }

    public function roleId(): int
    {
        return $this->roleId;
    }

    public function companyId(): string
    {
        return $this->companyId;
    }
}
