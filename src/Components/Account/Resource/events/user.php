<?php

use App\Components\Account\Domain\Event;
use App\Components\Account\Domain\Projection\UserProjection;

return [
    Event\UserCreated::class => [UserProjection::class],
    Event\UserLocaleRefreshed::class => [UserProjection::class],
    Event\UserPasswordChanged::class => [UserProjection::class],
    Event\UserRememberTokenRefreshed::class => [UserProjection::class],
    Event\UserRolesAssigned::class => [UserProjection::class],
];
