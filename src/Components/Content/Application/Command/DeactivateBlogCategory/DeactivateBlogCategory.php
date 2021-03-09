<?php

namespace App\Components\Content\Application\Command\DeactivateBlogCategory;

use App\Components\Content\Application\Command\BlogCategoryCommand;

class DeactivateBlogCategory extends BlogCategoryCommand
{
    /**
     * DeactivateBlogCategory constructor.
     *
     * @param string $id
     */
    public function __construct(string $id)
    {
        $this->setId($id);
    }
}
