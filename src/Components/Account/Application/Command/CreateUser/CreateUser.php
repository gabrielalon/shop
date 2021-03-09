<?php

namespace App\Components\Account\Application\Command\CreateUser;

use App\Components\Account\Application\Command\UserCommand;

class CreateUser extends UserCommand
{
    /** @var string */
    private $login;

    /** @var string */
    private $password;

    /**
     * CreateUser constructor.
     *
     * @param string $id
     * @param string $login
     * @param string $password
     */
    public function __construct(string $id, string $login, string $password)
    {
        $this->setId($id);
        $this->login = $login;
        $this->password = $password;
    }

    /**
     * @return string
     */
    public function login(): string
    {
        return $this->login;
    }

    /**
     * @return string
     */
    public function password(): string
    {
        return $this->password;
    }
}
