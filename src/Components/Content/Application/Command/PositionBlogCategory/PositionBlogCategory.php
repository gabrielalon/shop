<?php

namespace App\Components\Content\Application\Command\PositionBlogCategory;

use App\Components\Content\Application\Command\BlogCategoryCommand;

class PositionBlogCategory extends BlogCategoryCommand
{
    /** @var int */
    private $position;

    /** @var string|null */
    private $parentId;

    /**
     * PositionBlogCategory constructor.
     *
     * @param string      $id
     * @param int         $position
     * @param string|null $parentId
     */
    public function __construct(string $id, int $position, string $parentId = null)
    {
        $this->setId($id);
        $this->position = $position;
        $this->parentId = $parentId;
    }

    /**
     * @return int
     */
    public function position(): int
    {
        return $this->position;
    }

    /**
     * @return string|null
     */
    public function parentId(): ?string
    {
        return $this->parentId;
    }
}
