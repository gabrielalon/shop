<?php

namespace App\Components\Account\Infrastructure\Projection;

use App\Components\Account\Domain\Event;
use App\Components\Account\Domain\Projection\UserProjection;
use App\Components\Account\Infrastructure\Entity\User as UserEntity;
use Illuminate\Contracts\Container\BindingResolutionException;

final class UserEloquentProjector implements UserProjection
{
    /** @var UserEntity */
    private UserEntity $db;

    /**
     * UserEloquentProjector constructor.
     *
     * @param UserEntity $db
     */
    public function __construct(UserEntity $db)
    {
        $this->db = $db;
    }

    /**
     * {@inheritdoc}
     *
     * @throws BindingResolutionException
     */
    public function onUserCreated(Event\UserCreated $event): void
    {
        $this->db::createFromLogin(
            $event->userId()->toString(),
            $event->userLogin()->toString(),
            $event->userPassword()->toString()
        );
    }

    /**
     * {@inheritdoc}
     */
    public function onUserLocaleRefreshed(Event\UserLocaleRefreshed $event): void
    {
        if ($user = $this->db::findByUuid($event->userId()->toString())) {
            $user->update(['locale' => $event->userLocale()->toString()]);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function onUserPasswordChanged(Event\UserPasswordChanged $event): void
    {
        if ($user = $this->db::findByUuid($event->userId()->toString())) {
            $user->update(['password' => $event->userPassword()->toString()]);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function onUserRememberTokenRefreshed(Event\UserRememberTokenRefreshed $event): void
    {
        if ($user = $this->db::findByUuid($event->userId()->toString())) {
            $user->update(['remember_token' => $event->userRememberToken()->toString()]);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function onUserRolesAssigned(Event\UserRolesAssigned $event): void
    {
        if ($user = $this->db::findByUuid($event->userId()->toString())) {
            $user->assignRoles($event->userRoles()->roles());
        }
    }
}
