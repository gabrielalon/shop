<?php

namespace App\Components\Account\Infrastructure\Projection;

use App\Components\Account\Domain\Event;
use App\Components\Account\Domain\Projection\UserProjection;
use App\Components\Account\Infrastructure\Entity\Role;
use App\Components\Account\Infrastructure\Entity\User as UserEntity;
use App\Components\Account\Infrastructure\Entity\UserRole;
use Illuminate\Database\Eloquent\Model;

class UserEloquentProjector implements UserProjection
{
    /** @var UserEntity */
    private $db;

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
     */
    public function onUserCreated(Event\UserCreated $event): void
    {
        $this->db->newQuery()->create([
            'id' => $event->userId()->toString(),
            'login' => $event->userLogin()->toString(),
            'password' => $event->userPassword()->toString(),
            'locale' => locale()->current(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function onUserLocaleRefreshed(Event\UserLocaleRefreshed $event): void
    {
        if ($user = $this->findUser($event)) {
            $user->update(['locale' => $event->userLocale()->toString()]);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function onUserPasswordChanged(Event\UserPasswordChanged $event): void
    {
        if ($user = $this->findUser($event)) {
            $user->update(['password' => $event->userPassword()->toString()]);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function onUserRememberTokenRefreshed(Event\UserRememberTokenRefreshed $event): void
    {
        if ($user = $this->findUser($event)) {
            $user->update(['remember_token' => $event->userRememberToken()->toString()]);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function onUserRolesAssigned(Event\UserRolesAssigned $event): void
    {
        UserRole::query()->where(['user_id' => $event->userId()->toString()])->delete();
        foreach ($event->userRoles()->roles() as $type) {
            UserRole::query()->updateOrCreate([
                'user_id' => $event->userId()->toString(),
                'role_id' => Role::query()->updateOrCreate(['type' => $type])->getKey(),
            ]);
        }
    }

    /**
     * @param Event\UserEvent $event
     *
     * @return UserEntity|Model|null
     */
    public function findUser(Event\UserEvent $event): ?UserEntity
    {
        return UserEntity::findByUuid($event->userId()->toString());
    }
}
