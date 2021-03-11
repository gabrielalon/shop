<?php

namespace App\Integrations\Mapbox;

use App\Components\Content\Application\Service\SystemSettingRegistry;
use App\Components\Content\Domain\Enum\SystemSettingType;

final class MapboxConfig
{
    private static string $ACCESS_TOKEN = 'mapbox.config.access_token';
    private static string $CURL_TIMEOUT = 'mapbox.config.curl_timeout';
    private static string $CONNECTION_TIMEOUT = 'mapbox.config.connection_timeout';

    /** @var SystemSettingRegistry */
    private SystemSettingRegistry $settingRegistry;

    /**
     * MapboxConfig constructor.
     *
     * @param SystemSettingRegistry $settingRegistry
     */
    public function __construct(SystemSettingRegistry $settingRegistry)
    {
        $this->settingRegistry = $settingRegistry;
    }

    /**
     * @return string
     */
    public function accessToken(): string
    {
        return $this->settingRegistry->get(self::$ACCESS_TOKEN, SystemSettingType::STRING())->getValue();
    }

    /**
     * @return int
     */
    public function curlTimeout(): int
    {
        return $this->settingRegistry->get(self::$CURL_TIMEOUT, SystemSettingType::INTEGER(), 0)->getValue();
    }

    /**
     * @return int
     */
    public function connectionTimeout(): int
    {
        return $this->settingRegistry->get(self::$CONNECTION_TIMEOUT, SystemSettingType::INTEGER(), 0)->getValue();
    }
}
