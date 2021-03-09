<?php

namespace App\System\Messaging\Saga;

class State
{
    /** @var string */
    private $id;

    /** @var string|null */
    private $aggregateId;

    /** @var bool */
    private $done;

    /** @var \ArrayIterator */
    private $payload;

    /**
     * State constructor.
     *
     * @param string      $id
     * @param string|null $aggregateId
     * @param array       $payload
     */
    public function __construct(string $id, string $aggregateId = null, array $payload = [])
    {
        $this->id = $id;
        $this->done = false;
        $this->withAggregateId($aggregateId);
        $this->payload = new \ArrayIterator($payload);
    }

    /**
     * @param string|null $aggregateId
     */
    public function withAggregateId(string $aggregateId = null): void
    {
        $this->aggregateId = $aggregateId;
    }

    /**
     * @param string $key
     * @param $value
     *
     * @return State
     */
    public function set(string $key, $value): State
    {
        $this->payload->offsetSet($key, $value);

        return $this;
    }

    /**
     * @param string $key
     *
     * @return mixed|null
     */
    public function get(string $key)
    {
        if (false === $this->payload->offsetExists($key)) {
            return null;
        }

        return $this->payload->offsetGet($key);
    }

    /**
     * @return string
     */
    public function id(): string
    {
        return $this->id;
    }

    /**
     * @return bool
     */
    public function isDone(): bool
    {
        return $this->done;
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
        return $this->payload->getArrayCopy();
    }

    /**
     * @return State
     */
    public function markDone(): State
    {
        $state = clone $this;
        $state->done = true;

        return $state;
    }
}
