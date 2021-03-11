<?php

namespace App\Components\Content\Application\Command\DeactivateBlogEntry;

use App\Components\Content\Application\Command\BlogEntryCommandHandler;
use App\System\Messaging\Command\Command;

final class DeactivateBlogEntryHandler extends BlogEntryCommandHandler
{
    /**
     * {@inheritdoc}
     */
    public function run(Command $command): void
    {
        assert($command instanceof DeactivateBlogEntry);

        $entry = $this->repository->find($command->id());

        $entry->deactivate();

        $this->repository->save($entry);
    }
}
