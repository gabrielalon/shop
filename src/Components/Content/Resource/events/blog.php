<?php

use App\Components\Content\Domain\Event;
use App\Components\Content\Domain\Projection\BlogCategoryProjection;
use App\Components\Content\Domain\Projection\BlogEntryProjection;

return [
    Event\BlogCategoryCreated::class => [BlogCategoryProjection::class],
    Event\BlogCategoryTranslated::class => [BlogCategoryProjection::class],
    Event\BlogCategoryActivated::class => [BlogCategoryProjection::class],
    Event\BlogCategoryDeactivated::class => [BlogCategoryProjection::class],
    Event\BlogCategoryPositioned::class => [BlogCategoryProjection::class],
    Event\BlogCategoryRemoved::class => [BlogCategoryProjection::class],

    Event\BlogEntryCategorisedEvent::class => [BlogEntryProjection::class],
    Event\BlogEntryCreated::class => [BlogEntryProjection::class],
    Event\BlogEntryPublished::class => [BlogEntryProjection::class],
    Event\BlogEntryTranslated::class => [BlogEntryProjection::class],
    Event\BlogEntryActivated::class => [BlogEntryProjection::class],
    Event\BlogEntryDeactivated::class => [BlogEntryProjection::class],
    Event\BlogEntryRemoved::class => [BlogEntryProjection::class],
];
