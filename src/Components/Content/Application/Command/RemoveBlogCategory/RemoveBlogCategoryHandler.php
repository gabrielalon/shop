<?php

namespace App\Components\Content\Application\Command\RemoveBlogCategory;

use App\Components\Content\Application\Command\BlogCategoryCommandHandler;
use App\System\Messaging\Command\Command;

class RemoveBlogCategoryHandler extends BlogCategoryCommandHandler
{
    /**
     * {@inheritdoc}
     */
    public function run(Command $command): void
    {
        /* @var RemoveBlogCategory $command */

        $category = $this->repository->find($command->id());

        $category->remove();

        $this->repository->save($category);
    }
}
