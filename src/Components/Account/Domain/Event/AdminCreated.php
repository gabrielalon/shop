<?php

namespace App\Components\Account\Domain\Event;

use App\Components\Account\Domain\Admin;
use App\Components\Account\Domain\Valuing\Name;
use App\System\Messaging\Aggregate\AggregateRoot;
use App\System\Valuing\Char\Text;

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
     * @return Text
     */
    public function adminPassword(): Text
    {
        return Text::fromString($this->payload['password']);
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
        $admin->setPassword($this->adminPassword());
    }
}
