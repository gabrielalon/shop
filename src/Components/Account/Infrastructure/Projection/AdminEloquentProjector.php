<?php

namespace App\Components\Account\Infrastructure\Projection;

use App\Components\Account\Domain\Event;
use App\Components\Account\Domain\Projection\AdminProjection;
use App\Components\Account\Infrastructure\Entity\Admin as AdminEntity;
use Illuminate\Database\Eloquent\Model;

class AdminEloquentProjector implements AdminProjection
{
    /** @var AdminEntity */
    private $db;

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
     */
    public function onAdminCreated(Event\AdminCreated $event): void
    {
        $this->db->newQuery()->create([
            'id' => $event->adminId()->toString(),
            'first_name' => $event->adminName()->firstName(),
            'last_name' => $event->adminName()->lastName(),
            'email' => $event->adminEmail()->toString(),
            'user_id' => $event->adminUserId()->toString(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function onAdminNameChanged(Event\AdminNameChanged $event): void
    {
        if ($entity = $this->findAdmin($event)) {
            $entity->update([
                'first_name' => $event->adminName()->firstName(),
                'last_name' => $event->adminName()->lastName(),
            ]);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function onAdminRemoved(Event\AdminRemoved $event): void
    {
        if ($entity = $this->findAdmin($event)) {
            $entity->user->delete();
            $entity->delete();
        }
    }

    /**
     * @param Event\AdminEvent $event
     *
     * @return AdminEntity|Model|null
     */
    public function findAdmin(Event\AdminEvent $event): ?AdminEntity
    {
        return AdminEntity::findByUuid($event->adminId()->toString());
    }
}
