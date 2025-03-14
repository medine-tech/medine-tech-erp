<?php

declare(strict_types=1);

namespace MedineTech\Backoffice\CompanyUsers\Domain;

use MedineTech\Shared\Domain\Aggregate\AggregateRoot;

final class CompanyUser extends AggregateRoot
{
    public function __construct(
        private readonly string $companyId,
        private readonly int $userId,
    ) {
    }

    public static function create(string $companyId, int $userId): CompanyUser
    {
        $companyUser = new self($companyId, $userId);

        $aggregateId = $companyUser->companyId() . '-' . $companyUser->userId();
        $companyUser->record(new CompanyUserCreatedDomainEvent(
            $aggregateId,
            $companyUser->companyId(),
            $companyUser->userId()
        ));

        return $companyUser;
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
