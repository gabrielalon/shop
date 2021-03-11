<?php

use App\Components\Account\Domain\Event;
use App\Components\Account\Domain\Projection\AdminProjection;

return [
    Event\AdminCreated::class => [AdminProjection::class],
    Event\AdminNameChanged::class => [AdminProjection::class],
    Event\AdminLocaleRefreshed::class => [AdminProjection::class],
    Event\AdminRemoved::class => [AdminProjection::class],
];
