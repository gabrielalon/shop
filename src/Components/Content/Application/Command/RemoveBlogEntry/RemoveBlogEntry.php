<?php

namespace App\Components\Content\Application\Command\RemoveBlogEntry;

use App\Components\Content\Application\Command\BlogEntryCommand;

class RemoveBlogEntry extends BlogEntryCommand
{
    /**
     * RemoveBlogEntry constructor.
     *
     * @param string $id
     */
    public function __construct(string $id)
    {
        $this->setId($id);
    }
}
