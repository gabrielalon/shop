<?php

namespace App\Components\Content\Application\Command\ActivateBlogCategory;

use App\Components\Content\Application\Command\BlogCategoryCommand;

class ActivateBlogCategory extends BlogCategoryCommand
{
    /**
     * ActivateBlogCategory constructor.
     *
     * @param string $id
     */
    public function __construct(string $id)
    {
        $this->setId($id);
    }
}
