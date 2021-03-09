<?php

namespace App\Components\Content\Application\Command\TranslateBlogEntry;

use App\Components\Content\Application\Command\BlogEntryCommand;

class TranslateBlogEntry extends BlogEntryCommand
{
    /** @var string[] */
    private $name;

    /** @var string[] */
    private $description;

    /**
     * TranslateBlogEntry constructor.
     *
     * @param string   $id
     * @param string[] $name
     * @param string[] $description
     */
    public function __construct(string $id, array $name, array $description)
    {
        $this->setId($id);
        $this->name = $name;
        $this->description = $description;
    }

    /**
     * @return string[]
     */
    public function name(): array
    {
        return $this->name;
    }

    /**
     * @return string[]
     */
    public function description(): array
    {
        return $this->description;
    }
}
