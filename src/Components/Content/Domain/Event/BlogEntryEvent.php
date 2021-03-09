<?php

namespace App\Components\Content\Domain\Event;

use App\System\Messaging\Aggregate\AggregateChanged;
use App\System\Valuing\Identity\Uuid;

abstract class BlogEntryEvent extends AggregateChanged
{
    /**
     * @return Uuid
     */
    public function blogEntryId(): Uuid
    {
        return Uuid::fromIdentity($this->aggregateId());
    }
}
