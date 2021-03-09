<?php

namespace App\Components\Account\Application\Query\Model;

class AdminCollection extends \ArrayIterator
{
    /**
     * @param Admin $admin
     */
    public function add(Admin $admin): void
    {
        $this->offsetSet($admin->id(), $admin);
    }

    /**
     * @return Admin[]
     */
    public function all(): array
    {
        return $this->getArrayCopy();
    }
}
