<?php

namespace App\Components\Content\Application\Command\ActivateBlogCategory;

use App\Components\Content\Application\Command\BlogCategoryCommandHandler;
use App\System\Messaging\Command\Command;

final class ActivateBlogCategoryHandler extends BlogCategoryCommandHandler
{
    /**
     * {@inheritdoc}
     */
    public function run(Command $command): void
    {
        assert($command instanceof ActivateBlogCategory);

        $category = $this->repository->find($command->id());

        $category->activate();

        $this->repository->save($category);
    }
}
