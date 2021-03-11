<?php

namespace App\Components\Content\Application\Command\ActivateBlogEntry;

use App\Components\Content\Application\Command\BlogEntryCommandHandler;
use App\System\Messaging\Command\Command;

final class ActivateBlogEntryHandler extends BlogEntryCommandHandler
{
    /**
     * {@inheritdoc}
     */
    public function run(Command $command): void
    {
        assert($command instanceof ActivateBlogEntry);

        $entry = $this->repository->find($command->id());

        $entry->activate();

        $this->repository->save($entry);
    }
}
