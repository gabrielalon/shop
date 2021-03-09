<?php

namespace App\System\Messaging\Saga\State;

use App\System\Messaging\Aggregate\AggregateId;
use App\System\Messaging\Saga\State;

interface StateRepository
{
    /**
     * @param AggregateId $aggregateId
     * @param string      $sagaType
     *
     * @return State|null
     */
    public function findOneBy(AggregateId $aggregateId, string $sagaType): ?State;

    /**
     * @param State  $state
     * @param string $sagaType
     */
    public function save(State $state, string $sagaType): void;
}
