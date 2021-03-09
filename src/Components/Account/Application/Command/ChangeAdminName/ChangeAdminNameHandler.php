<?php

namespace App\Components\Account\Application\Command\ChangeAdminName;

use App\Components\Account\Application\Command\AdminCommandHandler;
use App\System\Messaging\Command\Command;

class ChangeAdminNameHandler extends AdminCommandHandler
{
    /**
     * {@inheritdoc}
     */
    public function run(Command $command): void
    {
        /** @var ChangeAdminName $command */
        $admin = $this->repository->find($command->id());

        $admin->changeName($command->firstName(), $command->lastName());

        $this->repository->flush($admin);
    }
}
