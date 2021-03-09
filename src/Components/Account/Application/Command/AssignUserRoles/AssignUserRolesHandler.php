<?php

namespace App\Components\Account\Application\Command\AssignUserRoles;

use App\Components\Account\Application\Command\UserCommandHandler;
use App\System\Messaging\Command\Command;

class AssignUserRolesHandler extends UserCommandHandler
{
    /**
     * {@inheritdoc}
     */
    public function run(Command $command): void
    {
        /** @var AssignUserRoles $command */
        $user = $this->repository->find($command->id());

        $user->assignRoles($command->roles());

        $this->repository->flush($user);
    }
}
