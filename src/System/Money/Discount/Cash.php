<?php

namespace App\System\Money\Discount;

use App\System\Money\Discount;
use App\System\Money\DiscountEnum;
use App\System\Money\Price;

class Cash extends Discount
{
    /**
     * {@inheritdoc}
     */
    public function apply(Price $price): Price
    {
        return $price->subtract($this->priceToSubtract($price));
    }

    /**
     * @param Price $basePrice
     *
     * @return Price
     */
    private function priceToSubtract(Price $basePrice): Price
    {
        return Price\Cents::buildByNett($basePrice->getCurrencySymbol(), $this->value, $basePrice->getTaxRate());
    }

    /**
     * {@inheritdoc}
     */
    protected function initType(): DiscountEnum
    {
        return DiscountEnum::CASH();
    }
}
