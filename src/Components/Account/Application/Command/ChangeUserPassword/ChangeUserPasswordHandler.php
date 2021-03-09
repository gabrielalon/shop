<?php

namespace App\Components\Account\Application\Command\ChangeUserPassword;

use App\Components\Account\Application\Command\UserCommandHandler;
use App\Components\Account\Domain\Persist\UserRepository;
use App\System\Messaging\Command\Command;
use Illuminate\Contracts\Hashing\Hasher;

class ChangeUserPasswordHandler extends UserCommandHandler
{
    /** @var Hasher */
    private $hasher;

    /**
     * ChangePasswordHandler constructor.
     *
     * @param Hasher         $hasher
     * @param UserRepository $repository
     */
    public function __construct(Hasher $hasher, UserRepository $repository)
    {
        $this->hasher = $hasher;
        parent::__construct($repository);
    }

    /**
     * {@inheritdoc}
     */
    public function run(Command $command): void
    {
        /** @var ChangeUserPassword $command */
        $user = $this->repository->find($command->id());

        $user->changePassword($this->hasher->make($command->password()));

        $this->repository->flush($user);
    }
}
