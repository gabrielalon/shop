<?php

namespace App\Components\Account\Application\Command\RefreshUserRememberToken;

use App\Components\Account\Application\Command\UserCommandHandler;
use App\System\Messaging\Command\Command;

final class RefreshUserRememberTokenHandler extends UserCommandHandler
{
    /**
     * {@inheritdoc}
     */
    public function run(Command $command): void
    {
        assert($command instanceof RefreshUserRememberToken);

        $user = $this->repository->find($command->id());

        $user->refreshRememberToken($command->rememberToken());

        $this->repository->flush($user);
    }
}
