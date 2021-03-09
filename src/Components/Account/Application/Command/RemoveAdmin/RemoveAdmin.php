<?php

namespace App\Components\Account\Application\Command\RemoveAdmin;

use App\Components\Account\Application\Command\AdminCommand;

class RemoveAdmin extends AdminCommand
{
    /**
     * RemoveAdmin constructor.
     *
     * @param string $id
     */
    public function __construct(string $id)
    {
        $this->setId($id);
    }
}
