<?php

namespace App\Components\Account\Infrastructure\Query;

use App\Components\Account\Application\Query\AdminQuery;
use App\Components\Account\Application\Query\Exception\AdminNotFoundException;
use App\Components\Account\Application\Query\Model\Admin;
use App\Components\Account\Application\Query\Model\AdminCollection;
use App\Components\Account\Infrastructure\Entity\Admin as AdminEntity;
use App\Components\Account\Infrastructure\Query\Model\AdminFactory;

final class AdminEloquentQuery implements AdminQuery
{
    /** @var AdminEntity */
    private AdminEntity $db;

    /** @var AdminFactory */
    private AdminFactory $factory;

    /**
     * AdminEloquentQuery constructor.
     *
     * @param AdminEntity  $db
     * @param AdminFactory $factory
     */
    public function __construct(AdminEntity $db, AdminFactory $factory)
    {
        $this->db = $db;
        $this->factory = $factory;
    }

    /**
     * {@inheritdoc}
     */
    public function existsAdminByEmail(string $email): bool
    {
        $condition = ['email' => $email];

        return $this->db->newQuery()->where($condition)->exists();
    }

    /**
     * {@inheritdoc}
     */
    public function findAdminById(string $id): Admin
    {
        if ($entity = AdminEntity::findByUuid($id)) {
            return $this->factory->fromEntity($entity);
        }

        throw AdminNotFoundException::fromId($id);
    }

    /**
     * {@inheritdoc}
     */
    public function findAdminByUserId(string $userId): Admin
    {
        $condition = ['user_id' => $userId];

        if ($entity = $this->db->newQuery()->where($condition)->first()) {
            assert($entity instanceof AdminEntity);

            return $this->factory->fromEntity($entity);
        }

        throw AdminNotFoundException::fromId($userId);
    }

    /**
     * {@inheritdoc}
     */
    public function findAdminCollection(): AdminCollection
    {
        $collection = new AdminCollection();

        foreach ($this->db->newQuery()->orderBy('created_at')->get()->all() as $entity) {
            assert($entity instanceof AdminEntity);
            $collection->add($this->factory->fromEntity($entity));
        }

        return $collection;
    }
}
