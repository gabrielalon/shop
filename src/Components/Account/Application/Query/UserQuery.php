<?php

namespace App\Components\Account\Application\Query;

use App\Components\Account\Application\Query\Exception\UserNotFoundException;
use App\Components\Account\Application\Query\Model\User;
use App\Components\Account\Domain\Enum\RoleEnum;
use App\System\Messaging\Query\Query;

interface UserQuery extends Query
{
    /**
     * @param string   $login
     * @param RoleEnum $role
     *
     * @return User
     *
     * @throws UserNotFoundException
     */
    public function findUserByLoginAndRole(string $login, RoleEnum $role): User;

    /**
     * @param string $id
     *
     * @return User
     *
     * @throws UserNotFoundException
     */
    public function findUserById(string $id): User;

    /**
     * @param string $id
     * @param string $token
     *
     * @return User
     */
    public function findUserByIdAndRememberToken(string $id, string $token): User;

    /**
     * @return int
     */
    public function totalUserCount(): int;
}
