<?php

namespace App\System\Money;

use LogicException;

final class Money
{
    /** @var float */
    private $value;

    /**
     * @param float|int $value
     */
    public function __construct($value)
    {
        if ($value < 0) {
            throw new LogicException('Money value must be positive');
        }

        $this->value = round((float) $value, 2);
    }

    /**
     * @param Money $money
     *
     * @return bool
     */
    public function isGreaterThan(Money $money): bool
    {
        //floating point calculations precision problem here
        return round($this->getValue(), 6) > round($money->getValue(), 6);
    }

    /**
     * @return float
     */
    public function getValue(): float
    {
        return $this->value;
    }
}
