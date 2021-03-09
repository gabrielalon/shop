<?php

namespace App\Components\Account\Domain\Event;

use App\Components\Account\Domain\Admin;
use App\Components\Account\Domain\Valuing\Name;
use App\System\Messaging\Aggregate\AggregateRoot;

class AdminNameChanged extends AdminEvent
{
    /**
     * @return Name
     */
    public function adminName(): Name
    {
        return Name::fromData($this->payload['first_name'], $this->payload['last_name']);
    }

    /**
     * {@inheritdoc}
     */
    public function populate(AggregateRoot $aggregateRoot): void
    {
        /** @var Admin $admin */
        $admin = $aggregateRoot;

        $admin->setName($this->adminName());
    }
}
