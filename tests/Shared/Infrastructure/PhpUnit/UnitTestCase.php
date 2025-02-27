<?php

declare(strict_types=1);

namespace Tests\Shared\Infrastructure\PhpUnit;

use Mockery;
use PHPUnit\Framework\TestCase as BaseTestCase;

abstract class UnitTestCase extends BaseTestCase
{
    /**
     * Crea un mock para la clase proporcionada.
     *
     * @param string $class
     * @return \Mockery\MockInterface
     */
    protected function mock(string $class)
    {
        return Mockery::mock($class);
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
}
