<?php

namespace App\Components\Account\Domain\Event;

use App\System\Messaging\Aggregate\AggregateChanged;
use App\System\Valuing\Identity\Uuid;

abstract class AdminEvent extends AggregateChanged
{
    /**
     * @return Uuid
     */
    public function adminId(): Uuid
    {
        return Uuid::fromIdentity($this->aggregateId());
    }
}
