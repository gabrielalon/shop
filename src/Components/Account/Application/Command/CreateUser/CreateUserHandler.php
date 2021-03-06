<?php

namespace App\Components\Account\Application\Command\CreateUser;

use App\Components\Account\Application\Command\UserCommandHandler;
use App\Components\Account\Domain\Persist\UserRepository;
use App\Components\Account\Domain\User;
use App\System\Messaging\Command\Command;
use Illuminate\Contracts\Hashing\Hasher;

final class CreateUserHandler extends UserCommandHandler
{
    /** @var Hasher */
    private Hasher $hasher;

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
        assert($command instanceof CreateUser);

        $this->repository->flush(User::create(
            $command->id(),
            $command->login(),
            $this->hasher->make($command->password())
        ));
    }
}
