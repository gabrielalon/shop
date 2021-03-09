<?php

namespace App\Components\Account\Domain\Event;

use App\Components\Account\Domain\Admin;
use App\Components\Account\Domain\Valuing\Name;
use App\System\Messaging\Aggregate\AggregateRoot;
use App\System\Valuing\Char\Text;
use App\System\Valuing\Identity\Uuid;

class AdminCreated extends AdminEvent
{
    /**
     * @return Name
     */
    public function adminName(): Name
    {
        return Name::fromData($this->payload['first_name'], $this->payload['last_name']);
    }

    /**
     * @return Text
     */
    public function adminEmail(): Text
    {
        return Text::fromString($this->payload['email']);
    }

    /**
     * @return Uuid
     */
    public function adminUserId(): Uuid
    {
        return Uuid::fromIdentity($this->payload['user_id']);
    }

    /**
     * {@inheritdoc}
     */
    public function populate(AggregateRoot $aggregateRoot): void
    {
        /** @var Admin $admin */
        $admin = $aggregateRoot;

        $admin->setId($this->adminId());
        $admin->setName($this->adminName());
        $admin->setEmail($this->adminEmail());
        $admin->setUserId($this->adminUserId());
    }
}
