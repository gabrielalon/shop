<?php

namespace App\Components\Content\Domain\Event;

use App\Components\Content\Domain\BlogCategory;
use App\System\Messaging\Aggregate\AggregateRoot;

class BlogCategoryCreated extends BlogCategoryEvent
{
    /**
     * {@inheritdoc}
     */
    public function populate(AggregateRoot $aggregateRoot): void
    {
        /** @var BlogCategory $entry */
        $entry = $aggregateRoot;

        $entry->setId($this->blogCategoryId());
    }
}
