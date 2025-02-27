<?php

declare(strict_types=1);

namespace Tests\Shared\Domain;

use Tests\Shared\Infrastructure\Mockery\MatcherIsSimilar;
use Tests\Shared\Infrastructure\PhpUnit\Constraint\ConstraintIsSimilar;

final readonly class TestUtils
{
    public static function isSimilar($expected, $actual): bool
    {
        return (new ConstraintIsSimilar($expected))->evaluate($actual, '', true);
    }

    public static function assertSimilar($expected, $actual): void
    {
        $constraint = new ConstraintIsSimilar($expected);

        $constraint->evaluate($actual);
    }

    public static function similarTo($value, $delta = 0.0): MatcherIsSimilar
    {
        return new MatcherIsSimilar($value, $delta);
    }
}
