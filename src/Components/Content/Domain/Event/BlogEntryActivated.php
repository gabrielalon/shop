<?php

namespace App\Components\Content\Domain\Event;

use App\Components\Content\Domain\BlogEntry;
use App\System\Messaging\Aggregate\AggregateRoot;
use App\System\Valuing\Option\Check;

class BlogEntryActivated extends BlogEntryEvent
{
    /**
     * @return Check
     */
    public function blogEntryActive(): Check
    {
        return Check::fromBoolean(true);
    }

    /**
     * {@inheritdoc}
     */
    public function populate(AggregateRoot $aggregateRoot): void
    {
        /** @var BlogEntry $entry */
        $entry = $aggregateRoot;

        $entry->setActive($this->blogEntryActive());
    }
}
