<?php

namespace App\Components\Account\Domain;

use App\System\Messaging\Aggregate\AggregateRoot;
use App\System\Valuing as VO;

final class User extends AggregateRoot
{
    /** @var VO\Char\Text */
    private $login;

    /** @var VO\Char\Text */
    private $password;

    /** @var VO\Intl\Language\Code */
    private $locale;

    /** @var VO\Char\Text */
    private $rememberToken;

    /** @var Valuing\Roles */
    private $roles;

    /**
     * @param VO\Identity\Uuid $id
     *
     * @return User
     */
    public function setId(VO\Identity\Uuid $id): User
    {
        $this->setAggregateId($id);

        return $this;
    }

    /**
     * @param VO\Char\Text $login
     *
     * @return User
     */
    public function setLogin(VO\Char\Text $login): User
    {
        $this->login = $login;

        return $this;
    }

    /**
     * @param VO\Char\Text $password
     *
     * @return User
     */
    public function setPassword(VO\Char\Text $password): User
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @param VO\Intl\Language\Code $locale
     *
     * @return User
     */
    public function setLocale(VO\Intl\Language\Code $locale): User
    {
        $this->locale = $locale;

        return $this;
    }

    /**
     * @param VO\Char\Text $rememberToken
     *
     * @return User
     */
    public function setRememberToken(VO\Char\Text $rememberToken): User
    {
        $this->rememberToken = $rememberToken;

        return $this;
    }

    /**
     * @param Valuing\Roles $roles
     *
     * @return User
     */
    public function setRoles(Valuing\Roles $roles): User
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @param string $id
     * @param string $login
     * @param string $password
     *
     * @return User
     */
    public static function create(string $id, string $login, string $password): User
    {
        $user = new static();

        $user->recordThat(Event\UserCreated::occur($id, [
            'login' => $login,
            'password' => $password,
        ]));

        return $user;
    }

    /**
     * @param string $locale
     */
    public function refreshLocale(string $locale): void
    {
        $this->recordThat(Event\UserLocaleRefreshed::occur($this->aggregateId(), [
            'locale' => $locale,
        ]));
    }

    /**
     * @param string $rememberToken
     */
    public function refreshRememberToken(string $rememberToken): void
    {
        $this->recordThat(Event\UserRememberTokenRefreshed::occur($this->aggregateId(), [
            'remember_token' => $rememberToken,
        ]));
    }

    /**
     * @param string[] $roles
     */
    public function assignRoles(array $roles): void
    {
        $this->recordThat(Event\UserRolesAssigned::occur($this->aggregateId(), [
            'roles' => $roles,
        ]));
    }

    /**
     * @param string $password
     */
    public function changePassword(string $password): void
    {
        $this->recordThat(Event\UserPasswordChanged::occur($this->aggregateId(), [
            'password' => $password,
        ]));
    }
}
