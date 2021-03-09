<?php

namespace App\Components\Content\Domain\Event;

use App\System\Messaging\Aggregate\AggregateChanged;
use App\System\Valuing\Identity\Uuid;

abstract class BlogCategoryEvent extends AggregateChanged
{
    /**
     * @return Uuid
     */
    public function blogCategoryId(): Uuid
    {
        return Uuid::fromIdentity($this->aggregateId());
    }
}
