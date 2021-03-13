<?php

namespace App\Components\Account\Domain\Enum;

use MyCLabs\Enum\Enum;

/**
 * @method static RoleEnum ADMIN()
 */
class RoleEnum extends Enum
{
    protected const ADMIN = 'admin';

    /**
     * @return string[]
     */
    public static function adminRoles(): array
    {
        return [self::ADMIN()->getValue()];
    }
}
