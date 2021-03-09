<?php

namespace App\Components\Content\Domain\Event;

use App\Components\Content\Domain\BlogCategory;
use App\System\Messaging\Aggregate\AggregateRoot;
use App\System\Valuing\Intl\Language\Texts;

class BlogCategoryTranslated extends BlogCategoryEvent
{
    /**
     * @return Texts
     */
    public function blogCategoryName(): Texts
    {
        return Texts::fromArray($this->payload['name']);
    }

    /**
     * {@inheritdoc}
     */
    public function populate(AggregateRoot $aggregateRoot): void
    {
        /** @var BlogCategory $entry */
        $entry = $aggregateRoot;

        $entry->setName($this->blogCategoryName());
    }
}
