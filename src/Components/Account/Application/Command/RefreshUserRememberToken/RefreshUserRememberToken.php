<?php

namespace App\Components\Account\Application\Command\RefreshUserRememberToken;

use App\Components\Account\Application\Command\UserCommand;

class RefreshUserRememberToken extends UserCommand
{
    /** @var string */
    private $rememberToken;

    /**
     * UserRememberTokenRefresh constructor.
     *
     * @param string $id
     * @param string $rememberToken
     */
    public function __construct(string $id, string $rememberToken)
    {
        $this->setId($id);
        $this->rememberToken = $rememberToken;
    }

    /**
     * @return string
     */
    public function rememberToken(): string
    {
        return $this->rememberToken;
    }
}
