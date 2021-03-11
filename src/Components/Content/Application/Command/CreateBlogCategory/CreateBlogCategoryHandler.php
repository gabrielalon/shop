<?php

namespace App\Components\Content\Application\Command\CreateBlogCategory;

use App\Components\Content\Application\Command\BlogCategoryCommandHandler;
use App\Components\Content\Domain\BlogCategory;
use App\System\Messaging\Command\Command;

final class CreateBlogCategoryHandler extends BlogCategoryCommandHandler
{
    /**
     * {@inheritdoc}
     */
    public function run(Command $command): void
    {
        assert($command instanceof CreateBlogCategory);

        $this->repository->save(BlogCategory::create($command->id()));
    }
}
