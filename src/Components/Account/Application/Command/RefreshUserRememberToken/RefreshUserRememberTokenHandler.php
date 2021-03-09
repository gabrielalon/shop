<?php

namespace App\Components\Account\Application\Command\RefreshUserRememberToken;

use App\Components\Account\Application\Command\UserCommandHandler;
use App\System\Messaging\Command\Command;

class RefreshUserRememberTokenHandler extends UserCommandHandler
{
    /**
     * {@inheritdoc}
     */
    public function run(Command $command): void
    {
        /** @var RefreshUserRememberToken $command */
        $user = $this->repository->find($command->id());

        $user->refreshRememberToken($command->rememberToken());

        $this->repository->flush($user);
    }
}
