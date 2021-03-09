<?php

namespace Tests;

use App\System\Messaging\Event\EventStreamRepository;
use App\System\Messaging\MessageBus;

trait CreatesMessaging
{
    /**
     * @return MessageBus
     */
    protected function messageBus(): MessageBus
    {
        return $this->app->get(MessageBus::class);
    }

    /**
     * @return EventStreamRepository
     */
    protected function eventStreamRepository(): EventStreamRepository
    {
        return $this->app->get(EventStreamRepository::class);
    }
}
