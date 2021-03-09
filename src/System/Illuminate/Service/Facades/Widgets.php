<?php

namespace App\System\Illuminate\Service\Facades;

use App\UI\Web\WidgetRegistry;
use Illuminate\Support\Facades\Facade;

class Widgets extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return WidgetRegistry::class;
    }
}
