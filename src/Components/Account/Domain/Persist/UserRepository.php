<?php

namespace App\Components\Account\Domain\Persist;

use App\Components\Account\Domain\User;

interface UserRepository
{
    /**
     * @param string $id
     *
     * @return User
     */
    public function find(string $id): User;

    /**
     * @param User $user
     */
    public function flush(User $user): void;
}
