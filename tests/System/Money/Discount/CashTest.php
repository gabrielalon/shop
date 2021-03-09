<?php

namespace Tests\System\Money\Discount;

use App\System\Money\Discount\Cash;
use App\System\Money\Price;
use Tests\System\Money\PriceTest;

class CashTest extends PriceTest
{
    /**
     * @test
     * @dataProvider cashDiscountDataProvider
     *
     * @param float $nett
     * @param float $discount
     * @param int   $tax
     */
    public function itAppliesCashDiscountTest(float $nett, float $discount, int $tax): void
    {
        $A = Price::buildByNett($this->currencySymbol, $nett, $tax);

        $price = (new Cash($discount * 10 ** 2))->apply($A);

        $this->assertEqualsWithDelta(
            round($A->getNett() - $discount, $price->getCurrency()->getPrecision()),
            $price->getNett(),
            0.0
        );
    }

    /**
     * @return array
     */
    public function cashDiscountDataProvider(): array
    {
        return [
            [100, 10.00, 5],
            [68.2927, 24.0000, 5],
            [31.7073, 19.0000, 23],

            [109.7561, 15.0000, 23],
            [109.7561, 35.0000, 23],
            [109.7561, 13.0001, 23],
            [109.7561, 25.0002, 23],
            [109.7561, 23.0003, 23],
            [109.7561, 45.0004, 23],
            [109.7561, 23.0005, 23],
            [109.7561, 43.0006, 23],
            [109.7561, 5.0007, 23],
            [109.7561, 2.0008, 23],
            [109.7561, 54.0009, 23],
            [109.7561, 99.0010, 23],
            [109.7561, 12.0020, 23],
            [109.7561, 21.0030, 23],
            [109.7561, 32.0040, 23],
            [110.16, 43.5000, 23],
        ];
    }
}
