<?php

namespace App\Components\Content\Application\Command\DeactivateBlogEntry;

use App\Components\Content\Application\Command\BlogEntryCommand;

class DeactivateBlogEntry extends BlogEntryCommand
{
    /**
     * DeactivateBlogEntry constructor.
     *
     * @param string $id
     */
    public function __construct(string $id)
    {
        $this->setId($id);
    }
}
