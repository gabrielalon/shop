<?php

namespace App\System\Illuminate\Service\Facades;

use App\System\Illuminate\Locale;
use Illuminate\Support\Facades\Facade;

class Loc extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return Locale::class;
    }
}
