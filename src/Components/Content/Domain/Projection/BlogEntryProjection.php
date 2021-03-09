<?php

namespace App\Components\Content\Domain\Projection;

use App\Components\Content\Domain\Event;

interface BlogEntryProjection
{
    /**
     * @param Event\BlogEntryCreated $event
     */
    public function onBlogEntryCreated(Event\BlogEntryCreated $event): void;

    /**
     * @param Event\BlogEntryTranslated $event
     */
    public function onBlogEntryTranslated(Event\BlogEntryTranslated $event): void;

    /**
     * @param Event\BlogEntryCategorisedEvent $event
     */
    public function onBlogEntryCategorisedEvent(Event\BlogEntryCategorisedEvent $event): void;

    /**
     * @param Event\BlogEntryPublished $event
     */
    public function onBlogEntryPublished(Event\BlogEntryPublished $event): void;

    /**
     * @param Event\BlogEntryActivated $event
     */
    public function onBlogEntryActivated(Event\BlogEntryActivated $event): void;

    /**
     * @param Event\BlogEntryDeactivated $event
     */
    public function onBlogEntryDeactivated(Event\BlogEntryDeactivated $event): void;

    /**
     * @param Event\BlogEntryRemoved $event
     */
    public function onBlogEntryRemoved(Event\BlogEntryRemoved $event): void;
}
