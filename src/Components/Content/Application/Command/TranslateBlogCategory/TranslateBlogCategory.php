<?php

namespace App\Components\Content\Application\Command\TranslateBlogCategory;

use App\Components\Content\Application\Command\BlogCategoryCommand;

class TranslateBlogCategory extends BlogCategoryCommand
{
    /** @var string[] */
    private $name;

    /**
     * TranslateBlogCategory constructor.
     *
     * @param string   $id
     * @param string[] $name
     */
    public function __construct(string $id, array $name)
    {
        $this->setId($id);
        $this->name = $name;
    }

    /**
     * @return string[]
     */
    public function name(): array
    {
        return $this->name;
    }
}
