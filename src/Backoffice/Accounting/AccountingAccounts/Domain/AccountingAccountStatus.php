<?php

declare(strict_types=1);

namespace MedineTech\Backoffice\Accounting\AccountingAccounts\Domain;

use InvalidArgumentException;

class AccountingAccountStatus
{
    public const ACTIVE = "active";
    public const INACTIVE = "inactive";

    private static array $statusName = [
        self::ACTIVE => 'Activo',
        self::INACTIVE => 'Inactivo',
    ];

    private readonly string $value;

    public function __construct(string $value)
    {
        $this->ensureIsValidStatus($value);
        $this->value = $value;
    }

    public function value(): string
    {
        return $this->value;
    }

    private function ensureIsValidStatus(string $value): void
    {
        if (!in_array($value, [
            self::ACTIVE,
            self::INACTIVE
        ])) {
            throw new InvalidArgumentException(sprintf('The status <%s> is invalid', $value));
        }
    }

    public function isEqual(AccountingAccountStatus $status): bool
    {
        return $this->value === $status->value();
    }

    public function statusName(): string
    {
        return self::$statusName[$this->value] ?? self::INACTIVE;
    }
}
