<?php

declare(strict_types=1);

namespace Tests\Shared\Infrastructure\PhpUnit;

use PHPUnit\Framework\TestCase;
use MedineTech\Shared\Domain\Bus\Event\DomainEvent;
use MedineTech\Shared\Domain\Bus\Event\EventBus;
use Mockery;
use Mockery\MockInterface;
use Tests\Shared\Domain\TestUtils;
use Tests\Shared\Infrastructure\Mockery\MatcherIsSimilar;

abstract class UnitTestCase extends TestCase
{
    protected function mock(string $className): MockInterface
    {
        return Mockery::mock($className);
    }

    protected function shouldPublishDomainEvent(DomainEvent $domainEvent): void
    {
        $this->eventBus()
            ->shouldReceive('publish')
            ->with($this->similarTo($domainEvent))
            ->andReturnNull();
    }

    protected function shouldNotPublishDomainEvent(): void
    {
        $this->eventBus()
            ->shouldReceive('publish')
            ->withNoArgs()
            ->andReturnNull();
    }

    protected function eventBus(): MockInterface
    {
        return $this->eventBus ??= $this->mock(EventBus::class);
    }

    protected function notify(DomainEvent $event, callable $subscriber): void
    {
        $subscriber($event);
    }

    protected function isSimilar($expected, $actual): bool
    {
        return TestUtils::isSimilar($expected, $actual);
    }

    protected function assertSimilar($expected, $actual): void
    {
        TestUtils::assertSimilar($expected, $actual);
    }

    protected function similarTo($value, $delta = 0.0): MatcherIsSimilar
    {
        return TestUtils::similarTo($value, $delta);
    }

    public function tearDown(): void {
        \Mockery::close();
    }
}
