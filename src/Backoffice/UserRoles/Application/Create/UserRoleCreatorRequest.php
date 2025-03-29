<?php

declare(strict_types=1);

namespace MedineTech\Backoffice\UserRoles\Application\Create;

final readonly class UserRoleCreatorRequest
{
    public function __construct(
        private int $userId,
        private int $roleId,
        private string $companyId
    ) {
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
