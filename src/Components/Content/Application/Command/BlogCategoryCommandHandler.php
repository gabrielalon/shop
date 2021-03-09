<?php

namespace App\Components\Content\Application\Command;

use App\Components\Content\Domain\Persist\BlogCategoryRepository;
use App\System\Messaging\Command\CommandHandler;

abstract class BlogCategoryCommandHandler implements CommandHandler
{
    /** @var BlogCategoryRepository */
    protected $repository;

    /**
     * CategoryCommandHandler constructor.
     *
     * @param BlogCategoryRepository $repository
     */
    public function __construct(BlogCategoryRepository $repository)
    {
        $this->repository = $repository;
    }
}
