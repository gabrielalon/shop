<?php

namespace App\Components\Content\Domain\Persist;

use App\Components\Content\Domain\BlogCategory;

interface BlogCategoryRepository
{
    /**
     * @param string $id
     *
     * @return BlogCategory
     */
    public function find(string $id): BlogCategory;

    /**
     * @param BlogCategory $entry
     */
    public function save(BlogCategory $entry): void;
}
