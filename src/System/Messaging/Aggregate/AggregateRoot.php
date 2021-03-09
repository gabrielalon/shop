<?php

namespace App\System\Messaging\Aggregate;

use App\System\Messaging\Snapshot\Snapshot;

abstract class AggregateRoot
{
    /** @var int */
    protected $version = 0;

    /** @var AggregateId */
    protected $aggregateId;

    /** @var AggregateChanged[] */
    protected $recordedEvents = [];

    final protected function __construct()
    {
    }

    /**
     * @param AggregateId $aggregateId
     */
    protected function setAggregateId(AggregateId $aggregateId): void
    {
        $this->aggregateId = $aggregateId;
    }

    /**
     * @param int $version
     *
     * @return AggregateRoot
     */
    private function setLastVersion(int $version): AggregateRoot
    {
        $this->version = $version;

        return $this;
    }

    /**
     * @return string
     */
    public function aggregateId(): string
    {
        return $this->aggregateId->toString();
    }

    /**
     * @return int
     */
    public function version(): int
    {
        return $this->version;
    }

    /**
     * @return string
     */
    public function aggregateType(): string
    {
        return get_called_class();
    }

    /**
     * @return AggregateChanged[]
     */
    public function popRecordedEvents(): array
    {
        $pendingEvents = $this->recordedEvents;

        $this->recordedEvents = [];

        return $pendingEvents;
    }

    /**
     * @param AggregateChanged $event
     */
    protected function recordThat(AggregateChanged $event): void
    {
        ++$this->version;

        $this->recordedEvents[] = $event->withVersion($this->version);

        $this->apply($event);
    }

    /**
     * @param \ArrayIterator $historyEvents
     *
     * @return AggregateRoot
     */
    public static function reconstituteFromHistory(\ArrayIterator $historyEvents): self
    {
        $instance = new static();
        $instance->replay($historyEvents);

        return $instance;
    }

    /**
     * @param Snapshot $snapshot
     */
    public function reconstituteFromSnapshot(Snapshot $snapshot): void
    {
        $this->setLastVersion($snapshot->lastVersion());
    }

    /**
     * @param \ArrayIterator $historyEvents
     */
    public function replay(\ArrayIterator $historyEvents): void
    {
        /** @var AggregateChanged $pastEvent */
        foreach ($historyEvents->getArrayCopy() as $pastEvent) {
            $this->setLastVersion($pastEvent->version())->apply($pastEvent);
        }
    }

    /**
     * @param AggregateChanged $event
     */
    protected function apply(AggregateChanged $event): void
    {
        $event->populate($this);
    }
}
