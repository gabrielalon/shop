<?php

namespace App\Components\Account\Domain;

use App\System\Messaging\Aggregate\AggregateRoot;
use App\System\Valuing as VO;

final class Admin extends AggregateRoot
{
    /** @var Valuing\Name */
    private $name;

    /** @var VO\Intl\Language\Code */
    private $locale;

    /** @var VO\Char\Text */
    private $email;

    /** @var VO\Char\Text */
    private $password;

    /**
     * @param VO\Identity\Uuid $id
     *
     * @return Admin
     */
    public function setId(VO\Identity\Uuid $id): Admin
    {
        $this->setAggregateId($id);

        return $this;
    }

    /**
     * @param Valuing\Name $name
     *
     * @return Admin
     */
    public function setName(Valuing\Name $name): Admin
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @param VO\Intl\Language\Code $locale
     *
     * @return Admin
     */
    public function setLocale(VO\Intl\Language\Code $locale): Admin
    {
        $this->locale = $locale;

        return $this;
    }

    /**
     * @param VO\Char\Text $email
     *
     * @return Admin
     */
    public function setEmail(VO\Char\Text $email): Admin
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @param VO\Char\Text $password
     *
     * @return Admin
     */
    public function setPassword(VO\Char\Text $password): Admin
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @param string $id
     * @param string $firstName
     * @param string $lastName
     * @param string $email
     * @param string $password
     *
     * @return Admin
     */
    public static function create(
        string $id,
        string $firstName,
        string $lastName,
        string $email,
        string $password
    ): Admin {
        $admin = new self();

        $admin->recordThat(Event\AdminCreated::occur($id, [
            'first_name' => $firstName,
            'last_name' => $lastName,
            'email' => $email,
            'password' => $password,
        ]));

        return $admin;
    }

    /**
     * @param string $firstName
     * @param string $lastName
     */
    public function changeName(string $firstName, string $lastName): void
    {
        $this->recordThat(Event\AdminNameChanged::occur($this->aggregateId(), [
            'first_name' => $firstName,
            'last_name' => $lastName,
        ]));
    }

    /**
     * @param string $locale
     */
    public function refreshLocale(string $locale): void
    {
        $this->recordThat(Event\AdminLocaleRefreshed::occur($this->aggregateId(), [
            'locale' => $locale,
        ]));
    }

    public function remove(): void
    {
        $this->recordThat(Event\AdminRemoved::occur($this->aggregateId()));
    }
}
