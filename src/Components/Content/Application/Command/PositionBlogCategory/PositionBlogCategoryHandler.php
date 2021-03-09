<?php

namespace App\Components\Content\Application\Command\PositionBlogCategory;

use App\Components\Content\Application\Command\BlogCategoryCommandHandler;
use App\System\Messaging\Command\Command;

class PositionBlogCategoryHandler extends BlogCategoryCommandHandler
{
    /**
     * {@inheritdoc}
     */
    public function run(Command $command): void
    {
        /* @var PositionBlogCategory $command */

        $category = $this->repository->find($command->id());

        $category->position($command->position(), $command->parentId());

        $this->repository->save($category);
    }
}
