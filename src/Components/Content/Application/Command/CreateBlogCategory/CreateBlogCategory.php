<?php

namespace App\Components\Content\Application\Command\CreateBlogCategory;

use App\Components\Content\Application\Command\BlogCategoryCommand;

class CreateBlogCategory extends BlogCategoryCommand
{
    /**
     * CreateBlogCategory constructor.
     *
     * @param string $id
     */
    public function __construct(string $id)
    {
        $this->setId($id);
    }
}
