<?php

namespace App\System\Money;

use MyCLabs\Enum\Enum;

/**
 * Class DiscountType.
 *
 * @method static DiscountEnum CASH()
 * @method static DiscountEnum PERCENTAGE()
 */
class DiscountEnum extends Enum
{
    protected const CASH = 'cash';
    protected const PERCENTAGE = 'percentage';
}
