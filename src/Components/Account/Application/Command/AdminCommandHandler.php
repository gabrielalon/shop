<?php

namespace App\Components\Account\Application\Command;

use App\Components\Account\Domain\Persist\AdminRepository;
use App\System\Messaging\Command\CommandHandler;

abstract class AdminCommandHandler implements CommandHandler
{
    /** @var AdminRepository */
    protected $repository;

    /**
     * AdminCommandHandler constructor.
     *
     * @param AdminRepository $repository
     */
    public function __construct(AdminRepository $repository)
    {
        $this->repository = $repository;
    }
}
