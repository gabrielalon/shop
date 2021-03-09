<?php

namespace App\Components\Account\Domain\Event;

use App\Components\Account\Domain\User;
use App\Components\Account\Domain\Valuing\Roles;
use App\System\Messaging\Aggregate\AggregateRoot;

class UserRolesAssigned extends UserEvent
{
    /**
     * @return Roles
     */
    public function userRoles(): Roles
    {
        return Roles::fromRoles($this->payload['roles']);
    }

    /**
     * {@inheritdoc}
     */
    public function populate(AggregateRoot $aggregateRoot): void
    {
        /** @var User $user */
        $user = $aggregateRoot;

        $user->setRoles($this->userRoles());
    }
}
