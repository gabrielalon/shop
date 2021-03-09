<?php

namespace App\Components\Content\Application\Command\PublishBlogEntry;

use App\Components\Content\Application\Command\BlogEntryCommandHandler;
use App\System\Messaging\Command\Command;

class PublishBlogEntryHandler extends BlogEntryCommandHandler
{
    /**
     * {@inheritdoc}
     */
    public function run(Command $command): void
    {
        /* @var PublishBlogEntry $command */

        $category = $this->repository->find($command->id());

        $category->publish($command->publishAt());

        $this->repository->save($category);
    }
}
