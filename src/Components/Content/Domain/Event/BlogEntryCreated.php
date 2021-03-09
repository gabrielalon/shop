<?php

namespace App\Components\Content\Domain\Event;

use App\Components\Content\Domain\BlogEntry;
use App\System\Messaging\Aggregate\AggregateRoot;

class BlogEntryCreated extends BlogEntryEvent
{
    /**
     * {@inheritdoc}
     */
    public function populate(AggregateRoot $aggregateRoot): void
    {
        /** @var BlogEntry $entry */
        $entry = $aggregateRoot;

        $entry->setId($this->blogEntryId());
    }
}
