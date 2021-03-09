<?php

namespace App\Components\Content\Application\Command\CategoriseBlogEntry;

use App\Components\Content\Application\Command\BlogEntryCommand;

class CategoriseBlogEntry extends BlogEntryCommand
{
    /** @var string[] */
    private $categoriesID;

    /**
     * CategoriseBlogEntry constructor.
     *
     * @param string[] $categoriesID
     */
    public function __construct(string $id, array $categoriesID)
    {
        $this->setId($id);
        $this->categoriesID = $categoriesID;
    }

    /**
     * @return string[]
     */
    public function categoriesID(): array
    {
        return $this->categoriesID;
    }
}
