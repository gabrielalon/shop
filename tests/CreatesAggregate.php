<?php

namespace Tests;

use App\System\Messaging\Aggregate\AggregateRoot;
use App\System\Messaging\Aggregate\AggregateRootDecorator;
use App\System\Messaging\Aggregate\AggregateTranslator;

trait CreatesAggregate
{
    /**
     * @param AggregateRoot $aggregateRoot
     *
     * @return array
     */
    protected function popRecordedEvents(AggregateRoot $aggregateRoot): array
    {
        return $this->getAggregateTranslator()->extractPendingStreamEvents($aggregateRoot);
    }

    /**
     * @param string $aggregateType
     * @param array  $events
     *
     * @return AggregateRoot
     */
    protected function reconstituteAggregateFromHistory(string $aggregateType, array $events): AggregateRoot
    {
        return $this->getAggregateTranslator()->reconstituteAggregateFromHistory(
            $aggregateType,
            new \ArrayIterator($events)
        );
    }

    /**
     * @return AggregateTranslator
     */
    private function getAggregateTranslator(): AggregateTranslator
    {
        return new AggregateTranslator(AggregateRootDecorator::newInstance());
    }
}
