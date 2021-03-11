<?php

namespace App\Components\Content\Application\Command\RemoveBlogEntry;

use App\Components\Content\Application\Command\BlogEntryCommandHandler;
use App\System\Messaging\Command\Command;

final class RemoveBlogEntryHandler extends BlogEntryCommandHandler
{
    /**
     * {@inheritdoc}
     */
    public function run(Command $command): void
    {
        assert($command instanceof RemoveBlogEntry);

        $category = $this->repository->find($command->id());

        $category->remove();

        $this->repository->save($category);
    }
}
