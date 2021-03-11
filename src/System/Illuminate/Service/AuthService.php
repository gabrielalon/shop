<?php

namespace App\System\Illuminate\Service;

use App\Components\Account\Account;
use App\Components\Account\Application\Query\Model\User;
use App\Components\Account\Domain\Enum\RoleEnum;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;

final class AuthService
{
    /** @var RoleEnum */
    private RoleEnum $role;

    /** @var Guard */
    private Guard $auth;

    /** @var Account */
    private Account $account;

    /**
     * AuthService constructor.
     *
     * @param Guard   $auth
     * @param Account $account
     */
    public function __construct(Guard $auth, Account $account)
    {
        $this->role = RoleEnum::ADMIN();
        $this->auth = $auth;
        $this->account = $account;
    }

    /**
     * @param RoleEnum $role
     *
     * @return AuthService
     */
    public function withRole(RoleEnum $role): AuthService
    {
        $this->role = $role;

        return $this;
    }

    /**
     * @param array $credentials
     * @param bool  $remember
     *
     * @return bool
     */
    public function login(array $credentials = [], bool $remember = false): bool
    {
        Arr::set($credentials, 'role', $this->role);

        return $this->auth->attempt($credentials, $remember);
    }

    /**
     * @param User $user
     */
    public function loginAsUser(User $user): void
    {
        Auth::login($user);
    }

    public function logout(): void
    {
        Auth::logout();
    }

    /**
     * @return bool
     */
    public function check(): bool
    {
        return $this->auth->check();
    }

    /**
     * @return User
     */
    public function user(): User
    {
        /** @var User $user */
        $user = $this->auth->user();

        return $user;
    }

    /**
     * @return User
     */
    public function reload(): User
    {
        /** @var User $user */
        $user = $this->auth->user();

        $user = $this->account->askUser()->findUserById($user->id());

        $this->loginAsUser($user);

        return $user;
    }
}
