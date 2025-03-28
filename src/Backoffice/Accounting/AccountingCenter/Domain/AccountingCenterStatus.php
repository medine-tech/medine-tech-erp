<?php

declare(strict_types=1);

namespace MedineTech\Backoffice\Accounting\AccountingCenter\Domain;

use InvalidArgumentException;

class AccountingCenterStatus
{
    public const ACTIVE = 'active';
    public const INACTIVE = 'inactive';

    private static array $statusNone = [
        self::ACTIVE => 'activo',
        self::INACTIVE => 'inactivo'
    ];

    private readonly string $value;

    public function __construct(string $value)
    {
        $this->ensureIsValidStatus($value);
        $this->value = $value;
    }

    private function value(): string
    {
        return $this->value;
    }

    private function ensureIsValidStatus(string $value): void
    {
        if (!in_array($value, [
            self::ACTIVE,
            self::INACTIVE
        ])) {
            throw new InvalidArgumentException(sprintf('"%s" is not a valid status', $value));
        }
    }

    public function isEqual(AccountingCenterStatus $status): bool
    {
        return $this->value() === $status->value();
    }

    public function statusName(): string
    {
        return self::$statusNone[$this->value()];
    }
}
