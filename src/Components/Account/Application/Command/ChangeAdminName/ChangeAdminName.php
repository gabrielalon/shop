<?php

namespace App\Components\Account\Application\Command\ChangeAdminName;

use App\Components\Account\Application\Command\AdminCommand;

class ChangeAdminName extends AdminCommand
{
    /** @var string */
    private $firstName;

    /** @var string */
    private $lastName;

    /**
     * ChangeAdminName constructor.
     *
     * @param string $id
     * @param string $firstName
     * @param string $lastName
     */
    public function __construct(string $id, string $firstName, string $lastName)
    {
        $this->setId($id);
        $this->firstName = $firstName;
        $this->lastName = $lastName;
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
}
