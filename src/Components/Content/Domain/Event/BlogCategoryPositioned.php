<?php

namespace App\Components\Content\Domain\Event;

use App\Components\Content\Domain\BlogCategory;
use App\System\Messaging\Aggregate\AggregateRoot;
use App\System\Valuing\Identity\Uuid;
use App\System\Valuing\Number\Number;

class BlogCategoryPositioned extends BlogCategoryEvent
{
    /**
     * @return Number
     */
    public function blogCategoryPosition(): Number
    {
        return Number::fromInt($this->payload['position']);
    }

    /**
     * @return Uuid|null
     */
    public function blogCategoryParentId(): ?Uuid
    {
        if (null === $this->payload['parent_id']) {
            return null;
        }

        return Uuid::fromIdentity($this->payload['parent_id']);
    }

    /**
     * {@inheritdoc}
     */
    public function populate(AggregateRoot $aggregateRoot): void
    {
        /** @var BlogCategory $entry */
        $entry = $aggregateRoot;

        $entry->setPosition($this->blogCategoryPosition());
        $entry->setParentId($this->blogCategoryParentId());
    }
}
