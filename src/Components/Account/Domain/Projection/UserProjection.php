<?php

namespace App\Components\Account\Domain\Projection;

use App\Components\Account\Domain\Event;

interface UserProjection
{
    /**
     * @param Event\UserCreated $event
     */
    public function onUserCreated(Event\UserCreated $event): void;

    /**
     * @param Event\UserLocaleRefreshed $event
     */
    public function onUserLocaleRefreshed(Event\UserLocaleRefreshed $event): void;

    /**
     * @param Event\UserPasswordChanged $event
     */
    public function onUserPasswordChanged(Event\UserPasswordChanged $event): void;

    /**
     * @param Event\UserRememberTokenRefreshed $event
     */
    public function onUserRememberTokenRefreshed(Event\UserRememberTokenRefreshed $event): void;

    /**
     * @param Event\UserRolesAssigned $event
     */
    public function onUserRolesAssigned(Event\UserRolesAssigned $event): void;
}
