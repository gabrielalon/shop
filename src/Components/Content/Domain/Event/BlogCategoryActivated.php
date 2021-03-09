<?php

namespace App\Components\Content\Domain\Event;

use App\Components\Content\Domain\BlogCategory;
use App\System\Messaging\Aggregate\AggregateRoot;
use App\System\Valuing\Option\Check;

class BlogCategoryActivated extends BlogCategoryEvent
{
    /**
     * @return Check
     */
    public function blogCategoryActive(): Check
    {
        return Check::fromBoolean(true);
    }

    /**
     * {@inheritdoc}
     */
    public function populate(AggregateRoot $aggregateRoot): void
    {
        /** @var BlogCategory $entry */
        $entry = $aggregateRoot;

        $entry->setActive($this->blogCategoryActive());
    }
}
