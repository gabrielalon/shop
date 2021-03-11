<?php

namespace App\Components\Account\Infrastructure\Query\Model;

use App\Components\Account\Application\Query\Model\Role;
use App\Components\Account\Domain\Enum\RoleEnum;
use App\Components\Account\Infrastructure\Entity\Role as RoleEntity;

final class RoleFactory
{
    /**
     * @param RoleEntity $entity
     *
     * @return Role
     */
    public function build(RoleEntity $entity): Role
    {
        return new Role(
            $entity->id,
            new RoleEnum($entity->type),
            $entity->descriptions()
        );
    }
}
