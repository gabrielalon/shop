<?php

namespace App\Components\Account\Application\Command;

use App\Components\Account\Domain\Persist\UserRepository;
use App\System\Messaging\Command\CommandHandler;

abstract class UserCommandHandler implements CommandHandler
{
    /** @var UserRepository */
    protected $repository;

    /**
     * UserCommandHandler constructor.
     *
     * @param UserRepository $repository
     */
    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }
}
