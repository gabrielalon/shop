<?php

namespace App\Components\Content\Domain\Enum;

use MyCLabs\Enum\Enum;

/**
 * @method static SystemSettingType BOOLEAN()
 * @method static SystemSettingType STRING()
 */
class SystemSettingType extends Enum
{
    protected const BOOLEAN = 'boolean';
    protected const STRING = 'string';
}
