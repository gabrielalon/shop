<?php

namespace App\Components\Content\Application\Service;

use App\Components\Content\Domain\Enum\SystemSettingType;
use App\Components\Content\Infrastructure\Entity\SystemSetting as SystemSettingEntity;

final class SystemSettingRegistry
{
    /** @var SystemSettingEntity */
    private SystemSettingEntity $db;

    /** @var \ArrayIterator */
    private \ArrayIterator $cache;

    /**
     * SystemSettingRegistry constructor.
     *
     * @param SystemSettingEntity $db
     */
    public function __construct(SystemSettingEntity $db)
    {
        $this->db = $db;
        $this->cache = new \ArrayIterator([]);
    }

    /**
     * @param string $key
     * @param string $dataType
     * @param mixed  $default
     *
     * @return SystemSettingEntity
     */
    public function get(string $key, string $dataType, mixed $default = ''): SystemSettingEntity
    {
        if (false === $this->cache->offsetExists($key)) {
            $this->cache->offsetSet($key, $this->db->newQuery()->updateOrCreate(['key' => $key], [
                'data_type' => (new SystemSettingType($dataType))->getValue(),
                'data' => $default,
            ]));
        }

        return $this->cache->offsetGet($key);
    }
}
