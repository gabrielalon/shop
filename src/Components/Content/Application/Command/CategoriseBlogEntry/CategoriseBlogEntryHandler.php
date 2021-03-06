<?php

namespace App\Components\Content\Application\Command\CategoriseBlogEntry;

use App\Components\Content\Application\Command\BlogEntryCommandHandler;
use App\System\Messaging\Command\Command;

final class CategoriseBlogEntryHandler extends BlogEntryCommandHandler
{
    /**
     * {@inheritdoc}
     */
    public function run(Command $command): void
    {
        assert($command instanceof CategoriseBlogEntry);

        $category = $this->repository->find($command->id());

        $category->categorise($command->categoriesID());

        $this->repository->save($category);
    }
}
