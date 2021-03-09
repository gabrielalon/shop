<?php

namespace App\System\Illuminate\Service\Facades;

use App\System\Spatie\Media\MediaService;
use Illuminate\Support\Facades\Facade;

class Media extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return MediaService::class;
    }
}
