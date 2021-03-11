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

final class UserAuthProvider implements AuthProvider
{
    /** @var Hasher */
    private Hasher $hasher;

    /** @var Account */
    private Account $account;

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
    public function retrieveById($identifier): ?User
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
    public function retrieveByToken($identifier, $token): ?User
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
    public function updateRememberToken(Authenticatable $user, $token): void
    {
        $this->account->refreshUserRememberToken($user->getAuthIdentifier(), $token);
    }

    /**
     * {@inheritdoc}
     */
    public function retrieveByCredentials(array $credentials): ?User
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
    public function validateCredentials(Authenticatable $user, array $credentials): bool
    {
        if (true === Arr::exists($credentials, 'password')) {
            $plain = $credentials['password'];

            return $this->hasher->check($plain, $user->getAuthPassword());
        }

        return false;
    }
}
