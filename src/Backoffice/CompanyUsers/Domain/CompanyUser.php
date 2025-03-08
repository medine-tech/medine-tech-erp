<?php

declare(strict_types=1);

namespace MedineTech\Backoffice\CompanyUsers\Domain;

final readonly class CompanyUser
{
    public function __construct(
        private string $companyId,
        private int $userId,
    ) {
    }

    public static function create(string $companyId, int $userId): CompanyUser
    {
        return new self($companyId, $userId);
    }

    public function companyId(): string
    {
        return $this->companyId;
    }

    public function userId(): int
    {
        return $this->userId;
    }

    public function toPrimitives(): array
    {
        return [
            'companyId' => $this->companyId(),
            'userId' => $this->userId(),
        ];
    }

    public static function fromPrimivites(array $primitives): CompanyUser
    {
        return new self(
            (string)$primitives['companyId'],
            (int)$primitives['userId'],
        );
    }
}
