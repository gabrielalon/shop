<?php

namespace App\Components\Account\Domain\Event;

use App\System\Messaging\Aggregate\AggregateChanged;
use App\System\Valuing\Identity\Uuid;

abstract class UserEvent extends AggregateChanged
{
    /**
     * @return Uuid
     */
    public function userId(): Uuid
    {
        return Uuid::fromIdentity($this->aggregateId());
    }
}
