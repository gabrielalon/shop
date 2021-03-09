<?php

namespace Tests\System\Money\Discount;

use App\System\Money\Discount\Percentage;
use App\System\Money\Price;
use Tests\System\Money\PriceTest;

class PercentageTest extends PriceTest
{
    /**
     * @test
     * @dataProvider percentageDiscountDataProvider
     *
     * @param float $gross
     * @param int   $discount
     * @param int   $tax
     */
    public function itAppliesCashDiscountTest(float $gross, int $discount, int $tax): void
    {
        $A = Price::buildByGross($this->currencySymbol, $gross, $tax);

        $price = (new Percentage($discount))->apply($A);

        $this->assertEqualsWithDelta(
            round($A->getGross() * (1 - $discount / 100), $price->getCurrency()->getPrecision()),
            $price->getGross(),
            0.0
        );
    }

    /**
     * @return array
     */
    public function percentageDiscountDataProvider(): array
    {
        return [
            [100, 10, 5],
            [68.2927, 24, 5],
            [31.7073, 19, 23],

            [109.7561, 15, 23],
            [109.7561, 35, 23],
            [109.7561, 13, 23],
            [109.7561, 25, 23],
            [109.7561, 23, 23],
            [109.7561, 45, 23],
            [109.7561, 23, 23],
            [109.7561, 43, 23],
            [109.7561, 5, 23],
            [109.7561, 2, 23],
            [109.7561, 54, 23],
            [109.7561, 99, 23],
            [109.7561, 12, 23],
            [109.7561, 21, 23],
            [109.7561, 32, 23],
            [110.16, 1, 23],
        ];
    }
}
