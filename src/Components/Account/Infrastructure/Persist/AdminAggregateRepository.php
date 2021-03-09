<?php

namespace App\Components\Account\Infrastructure\Persist;

use App\Components\Account\Domain\Admin;
use App\Components\Account\Domain\Persist\AdminRepository;
use App\System\Messaging\Aggregate\AggregateRepository;
use App\System\Valuing\Identity\Uuid;

class AdminAggregateRepository extends AggregateRepository implements AdminRepository
{
    /**
     * {@inheritdoc}
     */
    public function getAggregateRootClass(): string
    {
        return Admin::class;
    }

    /**
     * {@inheritdoc}
     */
    public function find(string $id): Admin
    {
        /** @var Admin $user */
        $user = $this->findAggregateRoot(Uuid::fromIdentity($id));

        return $user;
    }

    /**
     * {@inheritdoc}
     */
    public function flush(Admin $admin): void
    {
        $this->saveAggregateRoot($admin);
    }
}
