<?php

declare(strict_types=1);

namespace MedineTech\Backoffice\Accounting\AccountingAccounts\Domain;

use InvalidArgumentException;

class AccountingAccountType
{
    public const ASSET = 1;
    public const LIABILITY = 2;
    public const EQUITY = 3;
    public const REVENUE = 4;
    public const EXPENSE = 5;

    /** @var array<int, string> */
    private static array $typeName = [
        self::ASSET => 'Activo',
        self::LIABILITY => 'Pasivo',
        self::EQUITY => 'Patrimonio',
        self::REVENUE => 'Ingreso',
        self::EXPENSE => 'Gasto',
    ];

    private readonly int $value;

    public function __construct(int $value)
    {
        $this->ensureIsValidType($value);
        $this->value = $value;
    }

    public function value(): int
    {
        return $this->value;
    }

    private function ensureIsValidType(int $value): void
    {
        if (!in_array($value, [
            self::ASSET,
            self::LIABILITY,
            self::EQUITY,
            self::REVENUE,
            self::EXPENSE
        ])) {
            throw new InvalidArgumentException(sprintf('The type <%s> is invalid', $value));
        }
    }

    public function typeName(): int
    {
        return self::$typeName[$this->value] ?? self::EXPENSE;
    }
}
