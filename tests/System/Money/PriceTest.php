<?php

namespace Tests\System\Money;

use App\System\Money\Price;
use PHPUnit\Framework\TestCase as PHPUnitTestCase;

class PriceTest extends PHPUnitTestCase
{
    /** @var string */
    protected $currencySymbol = 'PLN';

    /**
     * @test
     */
    public function itBuildsInvalidPriceTest(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        Price::build($this->currencySymbol, 100, 300);
    }

    /**
     * @test
     */
    public function idAddsGrossPricesWithSameTaxTest(): void
    {
        $A = Price::buildByGross($this->currencySymbol, 100.00, 20);
        $B = Price::buildByGross($this->currencySymbol, 200.00, 20);

        $result = $A->add($B);

        $this->assertEqualsWithDelta(250.00, $result->getNett(), 0.0);
        $this->assertEqualsWithDelta(100 + 200, $result->getGross(), 0.0);
        $this->assertEqualsWithDelta(20, $result->getTaxRate(), 0.0);
    }

    /**
     * @test
     */
    public function idAddsNettPricesWithSameTaxTest(): void
    {
        $A = Price::buildByNett($this->currencySymbol, 100.00, 20);
        $B = Price::buildByNett($this->currencySymbol, 200.00, 20);

        $result = $A->add($B);

        $this->assertEqualsWithDelta(100 + 200, $result->getNett(), 0.0);
        $this->assertEqualsWithDelta(360.00, $result->getGross(), 0.0);
        $this->assertEqualsWithDelta(20, $result->getTaxRate(), 0.0);
    }

    /**
     * @test
     */
    public function itAddsGrossPricesWithDifferentTaxTest(): void
    {
        $A = Price::buildByGross($this->currencySymbol, 100.00, 20);
        $B = Price::buildByGross($this->currencySymbol, 200.00, 10);

        $result = $A->add($B);

        $this->assertEqualsWithDelta(265.15, $result->getNett(), 0.0);
        $this->assertEqualsWithDelta(100 + 200, $result->getGross(), 0.0);
    }

    /**
     * @test
     */
    public function itAddsNettPricesWithDifferentTaxTest(): void
    {
        $A = Price::buildByNett($this->currencySymbol, 100.00, 20);
        $B = Price::buildByNett($this->currencySymbol, 200.00, 10);

        $result = $A->add($B);

        $this->assertEqualsWithDelta(100 + 200, $result->getNett(), 0.0);
        $this->assertEqualsWithDelta(340, $result->getGross(), 0.0);
    }

    /**
     * @test
     */
    public function itSubtractsGrossPricesWithSameTaxTest(): void
    {
        $A = Price::buildByGross($this->currencySymbol, 100.00, 20);
        $B = Price::buildByGross($this->currencySymbol, 200.00, 20);

        $result = $B->subtract($A);

        $this->assertEqualsWithDelta(83.34, $result->getNett(), 0.0);
        $this->assertEqualsWithDelta(200 - 100, $result->getGross(), 0.0);
    }

    /**
     * @test
     */
    public function itSubtractsNettPricesWithSameTaxTest(): void
    {
        $A = Price::buildByNett($this->currencySymbol, 100.00, 20);
        $B = Price::buildByNett($this->currencySymbol, 200.00, 20);

        $result = $B->subtract($A);

        $this->assertEqualsWithDelta(200 - 100, $result->getNett(), 0.0);
        $this->assertEqualsWithDelta(120, $result->getGross(), 0.0);
    }

    /**
     * @test
     */
    public function itSubtractsGrossPricesWithDifferentTaxTest(): void
    {
        $A = Price::buildByGross($this->currencySymbol, 100.00, 20);
        $B = Price::buildByGross($this->currencySymbol, 200.00, 10);

        $result = $B->subtract($A);

        $this->assertEqualsWithDelta(98.49, $result->getNett(), 0.0);
        $this->assertEqualsWithDelta(200 - 100, $result->getGross(), 0.0);
    }

    /**
     * @test
     */
    public function itSubtractsNettPricesWithDifferentTaxTest(): void
    {
        $A = Price::buildByNett($this->currencySymbol, 100.00, 10);
        $B = Price::buildByNett($this->currencySymbol, 200.00, 20);

        $result = $B->subtract($A);

        $this->assertEqualsWithDelta(200 - 100, $result->getNett(), 0.0);
        $this->assertEqualsWithDelta(130, $result->getGross(), 0.0);
    }

    /**
     * @test
     * @dataProvider creatingDataProvider
     *
     * @param float $nett
     * @param float $gross
     * @param int   $tax
     */
    public function itBuildsNettTest(float $nett, float $gross, int $tax): void
    {
        $price = Price::buildByNett($this->currencySymbol, $nett, $tax);
        $this->assertEqualsWithDelta(round($gross, $price->getCurrency()->getPrecision()), $price->getGross(), 0.0);
    }

    /**
     * @test
     * @dataProvider creatingDataProvider
     *
     * @param float $nett
     * @param float $gross
     * @param int   $tax
     */
    public function itBuildsGrossTest(float $nett, float $gross, int $tax): void
    {
        $price = Price::buildByGross($this->currencySymbol, $gross, $tax);
        $this->assertEqualsWithDelta(round($nett, $price->getCurrency()->getPrecision()), $price->getNett(), 0.0);
    }

    /**
     * @test
     * @dataProvider creatingDataProvider
     *
     * @param float $nett
     * @param float $gross
     * @param int   $tax
     */
    public function itBuildsPriceTest(float $nett, float $gross, int $tax): void
    {
        $price = Price::build($this->currencySymbol, $nett, $gross);
        $this->assertEqualsWithDelta($tax, $price->getTaxRate(), 0.0);
    }

    /**
     * @return array
     */
    public function creatingDataProvider(): array
    {
        return [
            [100, 123, 23],
            [68.2927, 84.0000, 23],
            [31.7073, 39.0000, 23],

            [109.7561, 135.0000, 23],
            [109.7561, 135.0000, 23],
            [109.7561, 135.0001, 23],
            [109.7561, 135.0002, 23],
            [109.7561, 135.0003, 23],
            [109.7561, 135.0004, 23],
            [109.7561, 135.0005, 23],
            [109.7561, 135.0006, 23],
            [109.7561, 135.0007, 23],
            [109.7561, 135.0008, 23],
            [109.7561, 135.0009, 23],
            [109.7561, 135.0010, 23],
            [109.7561, 135.0020, 23],
            [109.7561, 135.0030, 23],
            [109.7561, 135.0040, 23],
            [110.16, 135.5000, 23],

            [0.81, 0.8748, 8],
        ];
    }

    /**
     * @test
     * @dataProvider addingDataProvider
     *
     * @param float $grossA
     * @param float $grossB
     * @param float $expectedGross
     */
    public function itAddsPricesTest(float $grossA, float $grossB, float $expectedGross): void
    {
        $tax = 5;
        $nettA = $grossA / (100 + $tax) * 100;
        $nettB = $grossB / (100 + $tax) * 100;

        $A = Price::build($this->currencySymbol, $nettA, $grossA);
        $B = Price::build($this->currencySymbol, $nettB, $grossB);

        $this->assertEqualsWithDelta($expectedGross, $A->add($B)->getGross(), 0.0);
        $this->assertEqualsWithDelta($expectedGross, $B->add($A)->getGross(), 0.0);

        $this->assertEqualsWithDelta($tax, $B->add($A)->getTaxRate(), 0.0);
        $this->assertEqualsWithDelta($tax, $A->add($B)->getTaxRate(), 0.0);

        $this->assertEqualsWithDelta($nettA, $A->getNett(), 0.01);
        $this->assertEqualsWithDelta($nettB, $B->getNett(), 0.01);
    }

    /**
     * @return array
     */
    public function addingDataProvider(): array
    {
        return [
            [123.00,     246.00,    369.00],
            [32.21,      33.32,     65.53],
        ];
    }

    /**
     * @test
     */
    public function itAddsDifferentCurrenciesTest(): void
    {
        $this->expectException(\LogicException::class);
        $A = Price::build($this->currencySymbol, 100, 130);
        $B = Price::build('USD', 300, 330);
        $A->add($B);
    }

    /**
     * @test
     */
    public function isNettGreaterThanGrossTest(): void
    {
        $this->expectException(\LogicException::class);
        Price::build($this->currencySymbol, 100.00, 90.00);
    }

    /**
     * @test
     */
    public function isNettSameAsGrossTest(): void
    {
        $price = Price::build($this->currencySymbol, 100.00, 100.00);
        $this->assertEqualsWithDelta(0, $price->getTaxRate(), 0.0);
    }

    /**
     * @test
     * @dataProvider isEqualDataProvider
     *
     * @param float $nettA
     * @param float $grossA
     * @param float $nettB
     * @param float $grossB
     * @param bool  $expectIsEqual
     */
    public function isEqualTest(float $nettA, float $grossA, float $nettB, float $grossB, bool $expectIsEqual): void
    {
        $A = Price::build($this->currencySymbol, $nettA, $grossA);
        $B = Price::build($this->currencySymbol, $nettB, $grossB);

        if ($expectIsEqual) {
            $this->assertTrue($A->isEqual($B));
            $this->assertTrue($B->isEqual($A));
        } else {
            $this->assertFalse($A->isEqual($B));
            $this->assertFalse($B->isEqual($A));
        }
    }

    /**
     * @return array
     */
    public function isEqualDataProvider(): array
    {
        return [
            [100.00,    123.00,     100.00,     123.00,     true],
            [100.00,    123.00,     100.01,     123.02,     false],
            [100.00,    123.00,     100.0014,   123.0021,   true], //fails with precision 4
        ];
    }

    /**
     * @test
     */
    public function multiplyTest(): void
    {
        $price = Price::build($this->currencySymbol, 120.00, 150.00);
        $result = $price->multiply(5);

        $this->assertEqualsWithDelta(600.00, $result->getNett(), 0.0);
        $this->assertEqualsWithDelta(750.00, $result->getGross(), 0.0);
        $this->assertEqualsWithDelta($this->currencySymbol, $result->getCurrencySymbol(), 0.0);
    }

    /**
     * @test
     */
    public function multiplyWithSpecificPriceTest(): void
    {
        $price = Price::build($this->currencySymbol, 1.36, 1.67);
        $result = $price->multiply(1.41);

        $result = clone $result;

        $this->assertEqualsWithDelta(1.91, $result->getNett(), 0.0);
        $this->assertEqualsWithDelta(2.35, $result->getGross(), 0.0);
        $this->assertEqualsWithDelta($this->currencySymbol, $result->getCurrencySymbol(), 0.0);
        $this->assertEqualsWithDelta(23, $result->getTaxRate(), 0.0);
    }

    /**
     * @test
     */
    public function divideTest(): void
    {
        $price = Price::buildByGross($this->currencySymbol, 233.29, 23);
        $price = $price->divide(3);
        $this->assertEqualsWithDelta(63.22, $price->getNett(), 0.0);
        $this->assertEqualsWithDelta(77.76, $price->getGross(), 0.0);
        $this->assertEqualsWithDelta(23, $price->getTaxRate(), 0.0);
    }

    /**
     * @test
     */
    public function divideWithSpecificPrice(): void
    {
        $price = Price::build($this->currencySymbol, 0.67, 0.82);
        $price = $price->divide(1);

        $this->assertEqualsWithDelta(0.67, $price->getNett(), 0.0);
        $this->assertEqualsWithDelta(0.82, $price->getGross(), 0.0);
        $this->assertEqualsWithDelta(22, $price->getTaxRate(), 0.0);
    }

    /**
     * @test
     */
    public function addEmptyToNonEmptyTest(): void
    {
        $A = Price::buildEmpty($this->currencySymbol);
        $B = Price::buildByGross($this->currencySymbol, 10.50, 19);

        $result1 = $A->add($B);
        $result2 = $B->add($A);

        $this->assertEqualsWithDelta($result1, $result2, 0.0);
        $this->assertEqualsWithDelta(19, $result1->getTaxRate(), 0.0);
        $this->assertEqualsWithDelta($this->currencySymbol, $result1->getCurrencySymbol(), 0.0);
        $this->assertEqualsWithDelta(19, $result2->getTaxRate(), 0.0);
        $this->assertEqualsWithDelta($this->currencySymbol, $result2->getCurrencySymbol(), 0.0);
    }

    /**
     * @test
     */
    public function addingEmptiesTest(): void
    {
        $list = [
            Price::buildEmpty($this->currencySymbol),
            Price::buildEmpty($this->currencySymbol),
        ];

        $total = Price::buildEmpty($this->currencySymbol);

        foreach ($list as $priceToAdd) {
            $total = $total->add($priceToAdd);
        }

        $this->assertEqualsWithDelta(0, $total->getGross(), 0.0);
        $this->assertEqualsWithDelta(0, $total->getNett(), 0.0);
        $this->assertEqualsWithDelta($this->currencySymbol, $total->getCurrency(), 0.0);
    }

    /**
     * @test
     */
    public function multiplyByZeroTest(): void
    {
        $price = Price::buildByNett($this->currencySymbol, 10.50, 19);

        $results = $price->multiply(0);

        $this->assertEqualsWithDelta(0, $results->getNett(), 0.0);
        $this->assertEqualsWithDelta(0, $results->getGross(), 0.0);
        $this->assertEqualsWithDelta(0, $results->getTaxRate(), 0.0);
    }
}
