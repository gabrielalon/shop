<?php

namespace App\Components\Content\Application\Command\CreateBlogEntry;

use App\Components\Content\Application\Command\BlogEntryCommand;

class CreateBlogEntry extends BlogEntryCommand
{
    /**
     * CreateBlogEntry constructor.
     *
     * @param string $id
     */
    public function __construct(string $id)
    {
        $this->setId($id);
    }
}
