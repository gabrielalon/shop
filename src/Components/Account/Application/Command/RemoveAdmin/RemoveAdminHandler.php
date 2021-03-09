<?php

namespace App\Components\Account\Application\Command\RemoveAdmin;

use App\Components\Account\Application\Command\AdminCommandHandler;
use App\System\Messaging\Command\Command;

class RemoveAdminHandler extends AdminCommandHandler
{
    /**
     * {@inheritdoc}
     */
    public function run(Command $command): void
    {
        /** @var RemoveAdmin $command */
        $admin = $this->repository->find($command->id());

        $admin->remove();

        $this->repository->flush($admin);
    }
}
