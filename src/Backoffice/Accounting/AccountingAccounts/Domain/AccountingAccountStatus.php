<?php

declare(strict_types=1);

namespace MedineTech\Backoffice\Accounting\AccountingAccounts\Domain;

use InvalidArgumentException;

class AccountingAccountStatus
{
    public const ACTIVE = 1;
    public const INACTIVE = 0;

    private static array $statusName = [
        self::ACTIVE => 'Activo',
        self::INACTIVE => 'Inactivo',
    ];

    private readonly int $value;

    public function __construct(int $value)
    {
        $this->ensureIsValidStatus($value);
        $this->value = $value;
    }

    public function value(): int
    {
        return $this->value;
    }

    private function ensureIsValidStatus(int $value): void
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

    public function statusName(): int
    {
        return self::$statusName[$this->value] ?? self::INACTIVE;
    }
}
