<?php

namespace App\Components\Account\Application\Saga\Scenario;

use App\System\Messaging\Saga\Scenario;

final class AdminCreate implements Scenario
{
    /** @var string */
    private string $id;

    /** @var string */
    private string $firstName;

    /** @var string */
    private string $lastName;

    /** @var string */
    private string $email;

    /** @var string */
    private string $password;

    /** @var string */
    private string $locale;

    /**
     * AdminCreate constructor.
     *
     * @param string $id
     * @param string $firstName
     * @param string $lastName
     * @param string $email
     * @param string $password
     * @param string $locale
     */
    public function __construct(
        string $id,
        string $firstName,
        string $lastName,
        string $email,
        string $password,
        string $locale
    ) {
        $this->id = $id;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->email = $email;
        $this->password = $password;
        $this->locale = $locale;
    }

    /**
     * @return string
     */
    public function id(): string
    {
        return $this->id;
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

    /**
     * @return string
     */
    public function locale(): string
    {
        return $this->locale;
    }
}
