<?php

namespace App\Components\Content\Application\Command\ActivateBlogEntry;

use App\Components\Content\Application\Command\BlogEntryCommand;

class ActivateBlogEntry extends BlogEntryCommand
{
    /**
     * ActivateBlogEntry constructor.
     *
     * @param string $id
     */
    public function __construct(string $id)
    {
        $this->setId($id);
    }
}
