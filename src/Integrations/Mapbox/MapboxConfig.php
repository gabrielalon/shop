<?php

namespace App\Integrations\Mapbox;

use App\Components\Content\Application\Service\SystemSettingRegistry;

class MapboxConfig
{
    /** @var SystemSettingRegistry */
    private $settingRegistry;

    /**
     * MapboxConfig constructor.
     *
     * @param SystemSettingRegistry $settingRegistry
     */
    public function __construct(SystemSettingRegistry $settingRegistry)
    {
        $this->settingRegistry = $settingRegistry;
    }

    public function accessToken(): string
    {
    }
}
