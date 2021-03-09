<?php

namespace App\System\Messaging\Event;

use App\System\Messaging\Aggregate\AggregateChanged;
use App\System\Messaging\Aggregate\AggregateId;

interface EventStreamRepository
{
    /**
     * @param AggregateChanged $event
     */
    public function save(AggregateChanged $event): void;

    /**
     * @param AggregateId $aggregateId
     * @param int         $lastVersion
     *
     * @return AggregateChanged[]
     */
    public function load(AggregateId $aggregateId, int $lastVersion): array;
}
