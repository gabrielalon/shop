<?php

namespace App\Components\Content\Application\Query\Model;

class BlogEntryCollection extends \ArrayIterator
{
    /**
     * @param BlogEntry $entry
     */
    public function add(BlogEntry $entry): void
    {
        $this->offsetSet($entry->id(), $entry);
    }

    /**
     * @return BlogEntry[]
     */
    public function all(): array
    {
        return $this->getArrayCopy();
    }
}
