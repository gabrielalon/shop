<?php

namespace App\Components\Content\Domain\Projection;

use App\Components\Content\Domain\Event;

interface BlogCategoryProjection
{
    /**
     * @param Event\BlogCategoryCreated $event
     */
    public function onBlogCategoryCreated(Event\BlogCategoryCreated $event): void;

    /**
     * @param Event\BlogCategoryTranslated $event
     */
    public function onBlogCategoryTranslated(Event\BlogCategoryTranslated $event): void;

    /**
     * @param Event\BlogCategoryActivated $event
     */
    public function onBlogCategoryActivated(Event\BlogCategoryActivated $event): void;

    /**
     * @param Event\BlogCategoryDeactivated $event
     */
    public function onBlogCategoryDeactivated(Event\BlogCategoryDeactivated $event): void;

    /**
     * @param Event\BlogCategoryPositioned $event
     */
    public function onBlogCategoryPositioned(Event\BlogCategoryPositioned $event): void;

    /**
     * @param Event\BlogCategoryRemoved $event
     */
    public function onBlogCategoryRemoved(Event\BlogCategoryRemoved $event): void;
}
