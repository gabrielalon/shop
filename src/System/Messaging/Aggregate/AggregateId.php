<?php

namespace App\System\Messaging\Aggregate;

interface AggregateId
{
    /**
     * @return string
     */
    public function toString(): string;
}
