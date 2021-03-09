<?php

namespace App\System\Messaging\Aggregate;

use Webmozart\Assert\Assert as Assertion;

class AggregateRootDecorator extends AggregateRoot
{
    /**
     * @return AggregateRootDecorator
     */
    public static function newInstance(): self
    {
        return new static();
    }

    /**
     * @param string $aggregateRootClass
     *
     * @throws \InvalidArgumentException
     */
    private function assertAggregateRootExistence(string $aggregateRootClass): void
    {
        Assertion::classExists($aggregateRootClass, 'Aggregate root class cannot be found. Got: %s');
    }

    /**
     * @param string      $aggregateType
     * @param AggregateId $aggregateId
     *
     * @return AggregateRoot
     *
     * @throws \InvalidArgumentException
     */
    public function fromAggregateData(string $aggregateType, AggregateId $aggregateId): AggregateRoot
    {
        $aggregateRoot = $this->fromHistory($aggregateType, new \ArrayIterator());
        $aggregateRoot->setAggregateId($aggregateId);

        return $aggregateRoot;
    }

    /**
     * @param string         $aggregateType
     * @param \ArrayIterator $aggregateChangedEvents
     *
     * @return AggregateRoot
     */
    public function fromHistory(string $aggregateType, \ArrayIterator $aggregateChangedEvents): AggregateRoot
    {
        /* @var AggregateRoot $aggregateRootClass * */
        $aggregateRootClass = $aggregateType;
        $this->assertAggregateRootExistence($aggregateRootClass);

        return $aggregateRootClass::reconstituteFromHistory($aggregateChangedEvents);
    }

    /**
     * @param AggregateRoot $aggregateRoot
     *
     * @return AggregateChanged[]
     */
    public function extractRecordedEvents(AggregateRoot $aggregateRoot): array
    {
        return $aggregateRoot->popRecordedEvents();
    }
}
