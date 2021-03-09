<?php

namespace App\Components\Account\Application\Command\CreateAdmin;

use App\Components\Account\Application\Command\AdminCommand;

class CreateAdmin extends AdminCommand
{
    /** @var string */
    private $firstName;

    /** @var string */
    private $lastName;

    /** @var string */
    private $email;

    /** @var string */
    private $userId;

    /**
     * CreateAdmin constructor.
     *
     * @param string $id
     * @param string $firstName
     * @param string $lastName
     * @param string $email
     * @param string $userId
     */
    public function __construct(
        string $id,
        string $firstName,
        string $lastName,
        string $email,
        string $userId
    ) {
        $this->setId($id);
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->email = $email;
        $this->userId = $userId;
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
    public function userId(): string
    {
        return $this->userId;
    }
}
