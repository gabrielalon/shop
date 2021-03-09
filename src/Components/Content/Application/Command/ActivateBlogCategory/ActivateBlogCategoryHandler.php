<?php

namespace App\Components\Content\Application\Command\ActivateBlogCategory;

use App\Components\Content\Application\Command\BlogCategoryCommandHandler;
use App\System\Messaging\Command\Command;

class ActivateBlogCategoryHandler extends BlogCategoryCommandHandler
{
    /**
     * {@inheritdoc}
     */
    public function run(Command $command): void
    {
        /* @var ActivateBlogCategory $command */

        $category = $this->repository->find($command->id());

        $category->activate();

        $this->repository->save($category);
    }
}
