<?php

namespace App\Components\Account\Application\Command\RefreshAdminLocale;

use App\Components\Account\Application\Command\AdminCommandHandler;
use App\System\Messaging\Command\Command;

final class RefreshAdminLocaleHandler extends AdminCommandHandler
{
    /**
     * {@inheritdoc}
     */
    public function run(Command $command): void
    {
        assert($command instanceof RefreshAdminLocale);

        $admin = $this->repository->find($command->id());

        $admin->refreshLocale($command->locale());

        $this->repository->flush($admin);
    }
}
