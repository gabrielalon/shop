<?php

namespace App\Components\Account\Application\Command\RefreshUserLocale;

use App\Components\Account\Application\Command\UserCommandHandler;
use App\System\Messaging\Command\Command;

final class RefreshUserLocaleHandler extends UserCommandHandler
{
    /**
     * {@inheritdoc}
     */
    public function run(Command $command): void
    {
        assert($command instanceof RefreshUserLocale);

        $user = $this->repository->find($command->id());

        $user->refreshLocale($command->locale());

        $this->repository->flush($user);
    }
}
