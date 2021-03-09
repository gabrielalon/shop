<?php

namespace App\Components\Content\Application\Command\TranslateBlogEntry;

use App\Components\Content\Application\Command\BlogEntryCommandHandler;
use App\System\Messaging\Command\Command;

class TranslateBlogEntryHandler extends BlogEntryCommandHandler
{
    /**
     * {@inheritdoc}
     */
    public function run(Command $command): void
    {
        /* @var TranslateBlogEntry $command */

        $category = $this->repository->find($command->id());

        $category->translate($command->name(), $command->description());

        $this->repository->save($category);
    }
}
