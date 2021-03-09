<?php

namespace App\Components\Account\Domain\Event;

use App\Components\Account\Domain\Admin;
use App\System\Messaging\Aggregate\AggregateRoot;

class AdminRemoved extends AdminEvent
{
    /**
     * {@inheritdoc}
     */
    public function populate(AggregateRoot $aggregateRoot): void
    {
        /** @var Admin $admin */
        $admin = $aggregateRoot;
    }
}
