<?php

namespace App\Components\Account\Application\Command\CreateAdmin;

use App\Components\Account\Application\Command\AdminCommandHandler;
use App\Components\Account\Domain\Admin;
use App\System\Messaging\Command\Command;

class CreateAdminHandler extends AdminCommandHandler
{
    /**
     * {@inheritdoc}
     */
    public function run(Command $command): void
    {
        /* @var CreateAdmin $command */

        $this->repository->flush(Admin::create(
            $command->id(),
            $command->firstName(),
            $command->lastName(),
            $command->email(),
            $command->userId()
        ));
    }
}
