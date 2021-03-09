<?php

namespace App\Components\Content\Application\Command;

use App\Components\Content\Domain\Persist\BlogEntryRepository;
use App\System\Messaging\Command\CommandHandler;

abstract class BlogEntryCommandHandler implements CommandHandler
{
    /** @var BlogEntryRepository */
    protected $repository;

    /**
     * EntryCommandHandler constructor.
     *
     * @param BlogEntryRepository $repository
     */
    public function __construct(BlogEntryRepository $repository)
    {
        $this->repository = $repository;
    }
}
