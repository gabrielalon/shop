<?php

namespace App\System\Messaging\Aggregate;

use App\System\Messaging\Event\EventStorage;
use App\System\Messaging\Snapshot\SnapshotStorage;

abstract class AggregateRepository
{
    /** @var EventStorage */
    protected $eventStorage;

    /** @var SnapshotStorage */
    protected $snapshotStorage;

    /**
     * @param EventStorage    $eventStorage
     * @param SnapshotStorage $snapshotStorage
     */
    public function __construct(EventStorage $eventStorage, SnapshotStorage $snapshotStorage)
    {
        $this->eventStorage = $eventStorage;
        $this->snapshotStorage = $snapshotStorage;
    }

    /**
     * @return string
     */
    abstract public function getAggregateRootClass(): string;

    /**
     * @param AggregateRoot $aggregateRoot
     *
     * @throws \Exception
     */
    protected function saveAggregateRoot(AggregateRoot $aggregateRoot): void
    {
        foreach ($aggregateRoot->popRecordedEvents() as $aggregateChanged) {
            $this->eventStorage->release($aggregateChanged)->record();
        }

        $this->snapshotStorage->make($aggregateRoot);
    }

    /**
     * @param AggregateId $aggregateId
     *
     * @return AggregateRoot
     */
    protected function findAggregateRoot(AggregateId $aggregateId): AggregateRoot
    {
        $snapshot = $this->snapshotStorage->get($this->getAggregateRootClass(), $aggregateId);
        $events = $this->eventStorage->load($aggregateId, $snapshot->lastVersion() + 1);

        $aggregateRoot = $snapshot->aggregateRoot();
        $aggregateRoot->reconstituteFromSnapshot($snapshot);
        $aggregateRoot->replay($events);

        return $aggregateRoot;
    }
}
