<?php

namespace App\System\Money\Discount;

use App\System\Money\Discount;
use App\System\Money\DiscountEnum;
use App\System\Money\Price;

class Percentage extends Discount
{
    /**
     * {@inheritdoc}
     */
    public function apply(Price $price): Price
    {
        $multiplier = (int) $this->value;
        if (100 === $multiplier) {
            return Price::buildEmpty($price->getCurrencySymbol());
        }

        return $price->multiply(1 - $multiplier / 100);
    }

    /**
     * {@inheritdoc}
     */
    protected function initType(): DiscountEnum
    {
        return DiscountEnum::PERCENTAGE();
    }
}
