<?php

namespace App\Components\Content\Application\Command\RemoveBlogCategory;

use App\Components\Content\Application\Command\BlogCategoryCommand;

class RemoveBlogCategory extends BlogCategoryCommand
{
    /**
     * RemoveBlogCategory constructor.
     *
     * @param string $id
     */
    public function __construct(string $id)
    {
        $this->setId($id);
    }
}
