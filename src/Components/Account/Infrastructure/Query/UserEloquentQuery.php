<?php

namespace App\Components\Account\Infrastructure\Query;

use App\Components\Account\Application\Query\Exception\UserNotFoundException;
use App\Components\Account\Application\Query\Model\User;
use App\Components\Account\Application\Query\UserQuery;
use App\Components\Account\Domain\Enum\RoleEnum;
use App\Components\Account\Infrastructure\Entity\User as UserEntity;
use App\Components\Account\Infrastructure\Query\Model\UserFactory;

final class UserEloquentQuery implements UserQuery
{
    /** @var UserEntity */
    private UserEntity $db;

    /** @var UserFactory */
    private UserFactory $factory;

    /**
     * UserEloquentQuery constructor.
     *
     * @param UserEntity  $db
     * @param UserFactory $factory
     */
    public function __construct(UserEntity $db, UserFactory $factory)
    {
        $this->db = $db;
        $this->factory = $factory;
    }

    /**
     * {@inheritdoc}
     */
    public function findUserByLoginAndRole(string $login, RoleEnum $role): User
    {
        $query = $this->db->newQuery()->selectRaw('user.*')
            ->join('user_role', 'user_role.user_id', '=', 'user.id')
            ->join('role', 'role.id', '=', 'user_role.role_id')
            ->where(['user.login' => $login, 'role.type' => $role->getValue()])
            ->with(['roles', 'permissions'])
        ;

        if ($entity = $query->first()) {
            assert($entity instanceof UserEntity);

            return $this->factory->fromEntity($entity);
        }

        throw UserNotFoundException::fromLogin($login);
    }

    /**
     * {@inheritdoc}
     */
    public function findUserById(string $id): User
    {
        if ($entity = UserEntity::findByUuid($id)) {
            return $this->factory->fromEntity($entity);
        }

        throw UserNotFoundException::fromId($id);
    }

    /**
     * {@inheritdoc}
     */
    public function findUserByIdAndRememberToken(string $id, string $token): User
    {
        $condition = ['id' => $id, 'remember_token' => $token];

        if ($entity = $this->db->newQuery()->where($condition)->first()) {
            assert($entity instanceof UserEntity);

            return $this->factory->fromEntity($entity);
        }

        throw UserNotFoundException::fromIdAndRememberToken($id, $token);
    }

    /**
     * {@inheritdoc}
     */
    public function totalUserCount(): int
    {
        return $this->db->newQuery()->count();
    }
}
