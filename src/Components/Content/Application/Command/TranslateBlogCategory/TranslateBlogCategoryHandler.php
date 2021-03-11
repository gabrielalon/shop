<?php

namespace App\Components\Content\Application\Command\TranslateBlogCategory;

use App\Components\Content\Application\Command\BlogCategoryCommandHandler;
use App\System\Messaging\Command\Command;

final class TranslateBlogCategoryHandler extends BlogCategoryCommandHandler
{
    /**
     * {@inheritdoc}
     */
    public function run(Command $command): void
    {
        assert($command instanceof TranslateBlogCategory);

        $category = $this->repository->find($command->id());

        $category->translate($command->name());

        $this->repository->save($category);
    }
}
