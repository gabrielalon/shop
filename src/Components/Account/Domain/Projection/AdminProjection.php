<?php

namespace App\Components\Account\Domain\Projection;

use App\Components\Account\Domain\Event;

interface AdminProjection
{
    /**
     * @param Event\AdminCreated $event
     */
    public function onAdminCreated(Event\AdminCreated $event): void;

    /**
     * @param Event\AdminNameChanged $event
     */
    public function onAdminNameChanged(Event\AdminNameChanged $event): void;

    /**
     * @param Event\AdminLocaleRefreshed $event
     */
    public function onAdminLocaleRefreshed(Event\AdminLocaleRefreshed $event): void;

    /**
     * @param Event\AdminRemoved $event
     */
    public function onAdminRemoved(Event\AdminRemoved $event): void;
}
