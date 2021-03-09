<?php

namespace App\Components\Content\Application\Command\DeactivateBlogCategory;

use App\Components\Content\Application\Command\BlogCategoryCommandHandler;
use App\System\Messaging\Command\Command;

class DeactivateBlogCategoryHandler extends BlogCategoryCommandHandler
{
    /**
     * {@inheritdoc}
     */
    public function run(Command $command): void
    {
        /* @var DeactivateBlogCategory $command */

        $entry = $this->repository->find($command->id());

        $entry->deactivate();

        $this->repository->save($entry);
    }
}
