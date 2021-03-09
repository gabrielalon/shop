<?php

namespace App\Components\Content\Domain\Event;

use App\Components\Content\Domain\BlogEntry;
use App\System\Messaging\Aggregate\AggregateRoot;
use Carbon\Carbon;

class BlogEntryPublished extends BlogEntryEvent
{
    /**
     * @return Carbon
     */
    public function blogEntryPublishedAt(): Carbon
    {
        return Carbon::createFromFormat('Y-m-d H:i:s', $this->payload['publish_at']);
    }

    /**
     * {@inheritdoc}
     */
    public function populate(AggregateRoot $aggregateRoot): void
    {
        /** @var BlogEntry $entry */
        $entry = $aggregateRoot;

        $entry->setPublishAt($this->blogEntryPublishedAt());
    }
}
