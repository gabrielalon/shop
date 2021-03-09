<?php

namespace App\Components\Account\Infrastructure\Query\Model;

use App\Components\Account\Application\Query\Model\User;
use App\Components\Account\Infrastructure\Entity\User as UserEntity;

class UserFactory
{
    /**
     * @param UserEntity $entity
     *
     * @return User
     */
    public function fromEntity(UserEntity $entity): User
    {
        return new User(
            $entity->id,
            $entity->locale,
            $entity->login,
            $entity->password,
            (string) $entity->remember_token,
            $entity->roleTypes(),
            $entity->permissionTypes()
        );
    }
}
