<?php

namespace App\System\Messaging\Aggregate;

abstract class AggregateChanged
{
    /** @var int */
    protected $version = 0;

    /** @var string */
    protected $aggregateId;

    /** @var array */
    protected $payload = [];

    /**
     * AggregateChanged constructor.
     *
     * @param string $aggregateId
     * @param array  $payload
     * @param int    $version
     */
    final protected function __construct(string $aggregateId, array $payload, int $version = 1)
    {
        $this->setAggregateId($aggregateId);
        $this->setVersion($version);
        $this->setPayload($payload);
    }

    /**
     * @param string $aggregateId
     * @param array  $payload
     *
     * @return AggregateChanged
     */
    public static function occur(string $aggregateId, array $payload = []): self
    {
        return new static($aggregateId, $payload);
    }

    /**
     * @return string
     */
    public function aggregateId(): string
    {
        return $this->aggregateId;
    }

    /**
     * @return array
     */
    public function payload(): array
    {
        return $this->payload;
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
    public function eventName(): string
    {
        return get_called_class();
    }

    /**
     * @return array
     */
    public function baseData(): array
    {
        return [
            'event_id' => $this->aggregateId(),
            'event_name' => $this->eventName(),
            'version' => $this->version(),
        ];
    }

    /**
     * @param AggregateRoot $aggregateRoot
     */
    abstract public function populate(AggregateRoot $aggregateRoot): void;

    /**
     * @param int $version
     */
    protected function setVersion(int $version): void
    {
        $this->version = $version;
    }

    /**
     * @param int $version
     *
     * @return AggregateChanged
     */
    public function withVersion(int $version): self
    {
        $self = clone $this;
        $self->setVersion($version);

        return $self;
    }

    /**
     * @param string $aggregateId
     */
    protected function setAggregateId(string $aggregateId): void
    {
        $this->aggregateId = $aggregateId;
    }

    /**
     * @param array $payload
     */
    protected function setPayload(array $payload): void
    {
        $this->payload = $payload;
    }
}
