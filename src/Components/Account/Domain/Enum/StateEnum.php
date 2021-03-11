<?php

namespace App\Components\Account\Domain\Enum;

use MyCLabs\Enum\Enum;

/**
 * @method static StateEnum ACTIVE()
 * @method static StateEnum BLOCKED()
 * @method static StateEnum INACTIVE()
 */
class StateEnum extends Enum
{
    protected const ACTIVE = 'active';
    protected const BLOCKED = 'blocked';
    protected const INACTIVE = 'inactive';
}
