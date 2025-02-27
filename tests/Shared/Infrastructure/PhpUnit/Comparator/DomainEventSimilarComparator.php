<?php

declare(strict_types=1);

namespace Tests\Shared\Infrastructure\PhpUnit\Comparator;

use MedineTech\Shared\Domain\Bus\Event\DomainEvent;
use ReflectionException;
use ReflectionObject;
use Tests\Shared\Domain\TestUtils;
use PHPUnit\Util\Exporter;
use SebastianBergmann\Comparator\Comparator;
use SebastianBergmann\Comparator\ComparisonFailure;

final class DomainEventSimilarComparator extends Comparator
{
    private static array $ignoredAttributes = ['eventId', 'occurredOn'];

    public function accepts($expected, $actual): bool
    {
        $domainEventRootClass = DomainEvent::class;

        return $expected instanceof $domainEventRootClass && $actual instanceof $domainEventRootClass;
    }

    public function assertEquals($expected, $actual, $delta = 0.0, $canonicalize = false, $ignoreCase = false): void
    {
        if (!$this->areSimilar($expected, $actual)) {
            throw new ComparisonFailure(
                $expected,
                $actual,
                Exporter::export($expected),
                Exporter::export($actual),
                'Failed asserting the events are equal.'
            );
        }
    }

    /**
     * @throws ReflectionException
     */
    private function areSimilar(DomainEvent $expected, DomainEvent $actual): bool
    {
        if (!$this->areTheSameClass($expected, $actual)) {
            return false;
        }

        return $this->propertiesAreSimilar($expected, $actual);
    }

    private function areTheSameClass(DomainEvent $expected, DomainEvent $actual): bool
    {
        return $expected::class === $actual::class;
    }

    /**
     * @throws ReflectionException
     */
    private function propertiesAreSimilar(DomainEvent $expected, DomainEvent $actual): bool
    {
        $expectedReflected = new ReflectionObject($expected);
        $actualReflected = new ReflectionObject($actual);

        foreach ($expectedReflected->getProperties() as $expectedReflectedProperty) {
            if (!in_array($expectedReflectedProperty->getName(), self::$ignoredAttributes, false)) {
                $actualReflectedProperty = $actualReflected->getProperty($expectedReflectedProperty->getName());

//                $expectedReflectedProperty->setAccessible(true);
//                $actualReflectedProperty->setAccessible(true);

                $expectedProperty = $expectedReflectedProperty->getValue($expected);
                $actualProperty = $actualReflectedProperty->getValue($actual);

                if (!TestUtils::isSimilar($expectedProperty, $actualProperty)) {
                    return false;
                }
            }
        }

        return true;
    }
}
