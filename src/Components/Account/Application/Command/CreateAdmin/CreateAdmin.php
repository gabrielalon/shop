<?php

namespace App\Components\Account\Application\Command\CreateAdmin;

use App\Components\Account\Application\Command\AdminCommand;

class CreateAdmin extends AdminCommand
{
    /** @var string */
    private string $firstName;

    /** @var string */
    private string $lastName;

    /** @var string */
    private string $email;

    /** @var string */
    private string $password;

    /**
     * CreateAdmin constructor.
     *
     * @param string $id
     * @param string $firstName
     * @param string $lastName
     * @param string $email
     * @param string $password
     */
    public function __construct(
        string $id,
        string $firstName,
        string $lastName,
        string $email,
        string $password
    ) {
        $this->setId($id);
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->email = $email;
        $this->password = $password;
    }

    /**
     * @return string
     */
    public function firstName(): string
    {
        return $this->firstName;
    }

    /**
     * @return string
     */
    public function lastName(): string
    {
        return $this->lastName;
    }

    /**
     * @return string
     */
    public function email(): string
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function password(): string
    {
        return $this->password;
    }
}
