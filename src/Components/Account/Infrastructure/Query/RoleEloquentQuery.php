<?php

namespace App\Components\Account\Infrastructure\Query;

use App\Components\Account\Application\Query\Model\RoleCollection;
use App\Components\Account\Application\Query\RoleQuery;
use App\Components\Account\Infrastructure\Entity\Role as RoleEntity;
use App\Components\Account\Infrastructure\Query\Model\RoleFactory;

final class RoleEloquentQuery implements RoleQuery
{
    /** @var RoleEntity */
    private RoleEntity $db;

    /** @var RoleFactory */
    private RoleFactory $factory;

    /**
     * RoleEloquentQuery constructor.
     *
     * @param RoleEntity  $db
     * @param RoleFactory $factory
     */
    public function __construct(RoleEntity $db, RoleFactory $factory)
    {
        $this->db = $db;
        $this->factory = $factory;
    }

    /**
     * {@inheritdoc}
     */
    public function findAllRoles(): RoleCollection
    {
        $collection = new RoleCollection();

        foreach ($this->db->newQuery()->with(['translations'])->orderBy('level')->get()->all() as $entity) {
            assert($entity instanceof RoleEntity);
            $collection->add($this->factory->build($entity));
        }

        return $collection;
    }
}
