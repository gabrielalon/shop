<?php

namespace App\System\Messaging\Saga\State;

use App\System\Messaging\Aggregate\AggregateId;
use App\System\Messaging\Saga\State;
use Illuminate\Support\Str;

class StateManager
{
    /** @var StateRepository */
    private $repository;

    /**
     * StateManager constructor.
     *
     * @param StateRepository $repository
     */
    public function __construct(StateRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param AggregateId|null $aggregateId
     * @param string           $sagaType
     *
     * @return State|null
     */
    public function findOneByAggregateSaga(?AggregateId $aggregateId, string $sagaType): ?State
    {
        if ($aggregateId instanceof AggregateId) {
            return $this->repository->findOneBy($aggregateId, $sagaType);
        }

        return new State(Str::uuid()->toString());
    }

    /**
     * @param State  $state
     * @param string $sagaType
     */
    public function store(State $state, string $sagaType): void
    {
        $this->repository->save($state, $sagaType);
    }
}
