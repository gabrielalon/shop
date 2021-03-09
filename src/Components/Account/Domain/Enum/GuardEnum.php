<?php

namespace App\Components\Account\Domain\Enum;

use MyCLabs\Enum\Enum;

/**
 * @method static GuardEnum API()
 * @method static GuardEnum WEB()
 */
class GuardEnum extends Enum
{
    protected const API = 'api';
    protected const WEB = 'web';
}
