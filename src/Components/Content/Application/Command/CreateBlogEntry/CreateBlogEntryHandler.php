<?php

namespace App\Components\Content\Application\Command\CreateBlogEntry;

use App\Components\Content\Application\Command\BlogEntryCommandHandler;
use App\Components\Content\Domain\BlogEntry;
use App\System\Messaging\Command\Command;

class CreateBlogEntryHandler extends BlogEntryCommandHandler
{
    /**
     * {@inheritdoc}
     */
    public function run(Command $command): void
    {
        /* @var CreateBlogEntry $command */

        $this->repository->save(BlogEntry::create($command->id()));
    }
}
