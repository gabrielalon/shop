<?php

namespace App\Components\Content\Application\Command\TranslateBlogEntry;

use App\Components\Content\Application\Command\BlogEntryCommandHandler;
use App\System\Messaging\Command\Command;

final class TranslateBlogEntryHandler extends BlogEntryCommandHandler
{
    /**
     * {@inheritdoc}
     */
    public function run(Command $command): void
    {
        assert($command instanceof TranslateBlogEntry);

        $category = $this->repository->find($command->id());

        $category->translate($command->name(), $command->description());

        $this->repository->save($category);
    }
}
