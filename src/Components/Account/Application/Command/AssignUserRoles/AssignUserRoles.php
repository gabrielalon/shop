<?php

namespace App\Components\Account\Application\Command\AssignUserRoles;

use App\Components\Account\Application\Command\UserCommand;

class AssignUserRoles extends UserCommand
{
    /** @var string[] */
    private array $roles;

    /**
     * AssignUserRole constructor.
     *
     * @param string $id
     * @param array  $roles
     */
    public function __construct(string $id, array $roles)
    {
        $this->setId($id);
        $this->roles = $roles;
    }

    /**
     * @return string[]
     */
    public function roles(): array
    {
        return $this->roles;
    }
}
