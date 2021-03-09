<?php

namespace App\Components\Account\Application\Command\ChangeUserPassword;

use App\Components\Account\Application\Command\UserCommand;

class ChangeUserPassword extends UserCommand
{
    /** @var string */
    private $password;

    /**
     * ChangeUserPassword constructor.
     *
     * @param string $id
     * @param string $password
     */
    public function __construct(string $id, string $password)
    {
        $this->setId($id);
        $this->password = $password;
    }

    /**
     * @return string
     */
    public function password(): string
    {
        return $this->password;
    }
}
