<?php

namespace App\Components\Account\Application\Query\Model;

class RoleCollection extends \ArrayIterator
{
    /**
     * @param Role $role
     */
    public function add(Role $role): void
    {
        $this->offsetSet($role->type(), $role);
    }

    /**
     * @return Role[]
     */
    public function all(): array
    {
        return $this->getArrayCopy();
    }
}
