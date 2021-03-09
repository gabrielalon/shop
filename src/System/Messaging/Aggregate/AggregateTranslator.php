<?php

namespace App\System\Messaging\Aggregate;

class AggregateTranslator
{
    /** @var AggregateRootDecorator */
    protected $aggregateRootDecorator;

    /**
     * AggregateTranslator constructor.
     *
     * @param AggregateRootDecorator $aggregateRootDecorator
     */
    public function __construct(AggregateRootDecorator $aggregateRootDecorator)
    {
        $this->aggregateRootDecorator = $aggregateRootDecorator;
    }

    /**
     * @param string      $aggregateType
     * @param AggregateId $aggregateId
     *
     * @return AggregateRoot
     */
    public function reconstituteAggregateFromType(string $aggregateType, AggregateId $aggregateId): AggregateRoot
    {
        return $this->aggregateRootDecorator->fromAggregateData($aggregateType, $aggregateId);
    }

    /**
     * @param string         $aggregateType
     * @param \ArrayIterator $historyEvents
     *
     * @return AggregateRoot
     */
    public function reconstituteAggregateFromHistory(string $aggregateType, \ArrayIterator $historyEvents): AggregateRoot
    {
        return $this->aggregateRootDecorator->fromHistory($aggregateType, $historyEvents);
    }

    /**
     * @param AggregateRoot $aggregateRoot
     *
     * @return AggregateChanged[]
     */
    public function extractPendingStreamEvents(AggregateRoot $aggregateRoot): array
    {
        return $this->aggregateRootDecorator->extractRecordedEvents($aggregateRoot);
    }
}
