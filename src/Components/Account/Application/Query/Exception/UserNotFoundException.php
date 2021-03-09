<?php

namespace App\Components\Account\Application\Query\Exception;

use App\System\Messaging\Query\Exception\ModelNotFoundException;

class UserNotFoundException extends ModelNotFoundException
{
    /**
     * @param string $login
     *
     * @return UserNotFoundException
     */
    public static function fromLogin(string $login): UserNotFoundException
    {
        $message = sprintf('User not found for given login %s', $login);

        return new self($message, 404);
    }

    /**
     * @param string $id
     *
     * @return UserNotFoundException
     */
    public static function fromId(string $id): UserNotFoundException
    {
        $message = sprintf('User not found for given id %s', $id);

        return new self($message, 404);
    }

    /**
     * @param string $id
     * @param string $token
     *
     * @return UserNotFoundException
     */
    public static function fromIdAndRememberToken(string $id, string $token): UserNotFoundException
    {
        $message = sprintf('User not found for given id %s and token %s', $id, $token);

        return new self($message, 404);
    }
}
