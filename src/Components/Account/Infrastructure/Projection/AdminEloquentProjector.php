<?php

namespace App\Components\Account\Infrastructure\Projection;

use App\Components\Account\Domain\Enum\RoleEnum;
use App\Components\Account\Domain\Event;
use App\Components\Account\Domain\Projection\AdminProjection;
use App\Components\Account\Infrastructure\Entity\Admin as AdminEntity;
use App\Components\Account\Infrastructure\Entity\User as UserEntity;
use Illuminate\Contracts\Container\BindingResolutionException;

final class AdminEloquentProjector implements AdminProjection
{
    /** @var AdminEntity */
    private AdminEntity $db;

    /**
     * AdminEloquentProjector constructor.
     *
     * @param AdminEntity $db
     */
    public function __construct(AdminEntity $db)
    {
        $this->db = $db;
    }

    /**
     * {@inheritdoc}
     *
     * @throws BindingResolutionException
     */
    public function onAdminCreated(Event\AdminCreated $event): void
    {
        $user = UserEntity::createFromEmail($event->adminEmail()->toString(), $event->adminPassword()->toString());

        $entity = $this->db->newQuery()->create([
            'id' => $event->adminId()->toString(),
            'first_name' => $event->adminName()->firstName(),
            'last_name' => $event->adminName()->lastName(),
            'user_id' => $user->id,
        ]);

        assert($entity instanceof AdminEntity);

        $entity->user->assignRoles(RoleEnum::adminRoles());
    }

    /**
     * {@inheritdoc}
     */
    public function onAdminNameChanged(Event\AdminNameChanged $event): void
    {
        if ($entity = $this->db::findByUuid($event->adminId()->toString())) {
            $entity->update([
                'first_name' => $event->adminName()->firstName(),
                'last_name' => $event->adminName()->lastName(),
            ]);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function onAdminLocaleRefreshed(Event\AdminLocaleRefreshed $event): void
    {
        if ($entity = $this->db::findByUuid($event->adminId()->toString())) {
            $entity->user->update(['locale' => $event->adminLocale()->toString()]);
        }
    }

    /**
     * {@inheritdoc}
     *
     * @throws \Exception
     */
    public function onAdminRemoved(Event\AdminRemoved $event): void
    {
        if ($entity = $this->db::findByUuid($event->adminId()->toString())) {
            $entity->user->delete();
            $entity->delete();
        }
    }
}
