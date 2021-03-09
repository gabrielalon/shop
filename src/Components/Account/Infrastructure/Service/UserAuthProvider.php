<?php

namespace App\Components\Account\Infrastructure\Service;

use App\Components\Account\Account;
use App\Components\Account\Application\Query\Exception\UserNotFoundException;
use App\Components\Account\Application\Query\Model\User;
use App\Components\Account\Domain\AuthProvider;
use App\Components\Account\Domain\Enum\RoleEnum;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Hashing\Hasher;
use Illuminate\Support\Arr;

class UserAuthProvider implements AuthProvider
{
    /** @var Hasher */
    private $hasher;

    /** @var Account */
    private $account;

    /**
     * UserAuthProvider constructor.
     *
     * @param Hasher  $hasher
     * @param Account $account
     */
    public function __construct(Hasher $hasher, Account $account)
    {
        $this->hasher = $hasher;
        $this->account = $account;
    }

    /**
     * {@inheritdoc}
     */
    public function retrieveById($identifier)
    {
        try {
            return $this->account->askUser()->findUserById($identifier);
        } catch (UserNotFoundException $exception) {
            return null;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function retrieveByToken($identifier, $token)
    {
        try {
            return $this->account->askUser()->findUserByIdAndRememberToken($identifier, $token);
        } catch (UserNotFoundException $exception) {
            return null;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function updateRememberToken(Authenticatable $user, $token)
    {
        $this->account->refreshUserRememberToken($user->getAuthIdentifier(), $token);
    }

    /**
     * {@inheritdoc}
     */
    public function retrieveByCredentials(array $credentials)
    {
        $user = null;

        if ($login = Arr::get($credentials, 'email', false)) {
            $role = Arr::get($credentials, 'role', RoleEnum::ADMIN());

            return $this->retrieveByLoginAndRole($login, $role);
        }

        return null;
    }

    /**
     * @param string   $login
     * @param RoleEnum $role
     *
     * @return User|null
     */
    private function retrieveByLoginAndRole(string $login, RoleEnum $role): ?User
    {
        try {
            return $this->account->askUser()->findUserByLoginAndRole($login, $role);
        } catch (UserNotFoundException $exception) {
            return null;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function validateCredentials(Authenticatable $user, array $credentials)
    {
        if (Arr::exists($credentials, 'password')) {
            $plain = $credentials['password'];

            /* @var User $user */
            return $this->hasher->check($plain, $user->getAuthPassword());
        }

        return false;
    }
}
