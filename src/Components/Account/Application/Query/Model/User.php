<?php

namespace App\Components\Account\Application\Query\Model;

use Illuminate\Contracts\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\CanResetPassword;

class User implements Authenticatable, Authorizable, CanResetPassword
{
    /** @var string */
    private $id;

    /** @var string */
    private $locale;

    /** @var string */
    private $login;

    /** @var string */
    private $password;

    /** @var string */
    private $rememberToken;

    /** @var string[] */
    private $roles;

    /** @var string[] */
    private $permissions;

    /**
     * User constructor.
     *
     * @param string   $id
     * @param string   $locale
     * @param string   $login
     * @param string   $password
     * @param string   $rememberToken
     * @param string[] $roles
     * @param string[] $permissions
     */
    public function __construct(
        string $id,
        string $locale,
        string $login,
        string $password,
        string $rememberToken,
        array $roles,
        array $permissions
    ) {
        $this->id = $id;
        $this->locale = $locale;
        $this->login = $login;
        $this->password = $password;
        $this->rememberToken = $rememberToken;
        $this->roles = $roles;
        $this->permissions = $permissions;
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
    public function locale(): string
    {
        return $this->locale;
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

    /**
     * @return string
     */
    public function rememberToken(): string
    {
        return $this->rememberToken;
    }

    /**
     * @return string[]
     */
    public function roles(): array
    {
        return $this->roles;
    }

    /**
     * @return string[]
     */
    public function permissions(): array
    {
        return $this->permissions;
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthIdentifierName(): string
    {
        return 'id';
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthIdentifier(): string
    {
        return $this->id();
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthPassword(): string
    {
        return $this->password();
    }

    /**
     * {@inheritdoc}
     */
    public function getRememberToken(): string
    {
        return $this->rememberToken();
    }

    /**
     * {@inheritdoc}
     */
    public function setRememberToken($value): void
    {
        $this->rememberToken = $value;
    }

    /**
     * {@inheritdoc}
     */
    public function getRememberTokenName(): string
    {
        return 'remember_token';
    }

    /**
     * {@inheritdoc}
     */
    public function can($ability, $arguments = [])
    {
        return in_array($ability, $this->permissions(), true);
    }

    /**
     * {@inheritdoc}
     */
    public function getEmailForPasswordReset()
    {
        return $this->login();
    }

    /**
     * {@inheritdoc}
     */
    public function sendPasswordResetNotification($token)
    {
    }

    /**
     * @param array $roles
     *
     * @return bool
     */
    public function hasAnyRole(array $roles = []): bool
    {
        foreach ($roles as $role) {
            if (true === $this->hasRole($role)) {
                return true;
            }
        }

        return false;
    }

    /**
     * @param string $role
     *
     * @return bool
     */
    public function hasRole(string $role): bool
    {
        return in_array($role, $this->roles(), true);
    }
}
