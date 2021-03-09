<?php

namespace App\Components\Content\Domain\Event;

use App\Components\Content\Domain\BlogEntry;
use App\System\Messaging\Aggregate\AggregateRoot;
use App\System\Valuing\Identity\Uuids;

class BlogEntryCategorisedEvent extends BlogEntryEvent
{
    /**
     * @return Uuids
     */
    public function blogEntryCategoryIds(): Uuids
    {
        return Uuids::fromArray($this->payload['categories_id']);
    }

    /**
     * {@inheritdoc}
     */
    public function populate(AggregateRoot $aggregateRoot): void
    {
        /** @var BlogEntry $entry */
        $entry = $aggregateRoot;

        $entry->setCategories($this->blogEntryCategoryIds());
    }
}
