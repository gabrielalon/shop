<?php

namespace App\Components\Account\Infrastructure\Persist;

use App\Components\Account\Domain\Persist\UserRepository;
use App\Components\Account\Domain\User;
use App\System\Messaging\Aggregate\AggregateRepository;
use App\System\Valuing\Identity\Uuid;

class UserAggregateRepository extends AggregateRepository implements UserRepository
{
    /**
     * {@inheritdoc}
     */
    public function getAggregateRootClass(): string
    {
        return User::class;
    }

    /**
     * {@inheritdoc}
     */
    public function find(string $id): User
    {
        /** @var User $user */
        $user = $this->findAggregateRoot(Uuid::fromIdentity($id));

        return $user;
    }

    /**
     * {@inheritdoc}
     */
    public function flush(User $user): void
    {
        $this->saveAggregateRoot($user);
    }
}
