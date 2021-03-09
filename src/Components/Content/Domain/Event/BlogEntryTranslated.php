<?php

namespace App\Components\Content\Domain\Event;

use App\Components\Content\Domain\BlogEntry;
use App\System\Messaging\Aggregate\AggregateRoot;
use App\System\Valuing\Intl\Language\Contents;
use App\System\Valuing\Intl\Language\Texts;

class BlogEntryTranslated extends BlogEntryEvent
{
    /**
     * @return Texts
     */
    public function blogEntryName(): Texts
    {
        return Texts::fromArray($this->payload['name']);
    }

    /**
     * @return Contents
     */
    public function blogEntryDescription(): Contents
    {
        return Contents::fromArray($this->payload['description']);
    }

    /**
     * {@inheritdoc}
     */
    public function populate(AggregateRoot $aggregateRoot): void
    {
        /** @var BlogEntry $entry */
        $entry = $aggregateRoot;

        $entry->setName($this->blogEntryName());
        $entry->setDescription($this->blogEntryDescription());
    }
}
