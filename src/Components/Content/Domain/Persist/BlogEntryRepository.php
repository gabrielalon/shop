<?php

namespace App\Components\Content\Domain\Persist;

use App\Components\Content\Domain\BlogEntry;

interface BlogEntryRepository
{
    /**
     * @param string $id
     *
     * @return BlogEntry
     */
    public function find(string $id): BlogEntry;

    /**
     * @param BlogEntry $entry
     */
    public function save(BlogEntry $entry): void;
}
