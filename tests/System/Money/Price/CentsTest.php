<?php

namespace Tests\System\Money\Price;

use App\System\Money\Price;
use PHPUnit\Framework\TestCase as PHPUnitTestCase;

class CentsTest extends PHPUnitTestCase
{
    /** @var string */
    protected $currencySymbol = 'PLN';

    /**
     * @test
     */
    public function itBuildsInvalidPriceTest(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        Price\Cents::build($this->currencySymbol, 100, 300);
    }

    /**
     * @test
     */
    public function idAddsGrossPricesWithSameTaxTest(): void
    {
        $A = Price\Cents::buildByGross($this->currencySymbol, 10000, 20);
        $B = Price\Cents::buildByGross($this->currencySymbol, 20000, 20);

        $result = $A->add($B);

        $this->assertEqualsWithDelta(25000, $result->toCents()->getNett(), 0.0);
        $this->assertEqualsWithDelta(10000 + 20000, $result->toCents()->getGross(), 0.0);
        $this->assertEqualsWithDelta(20, $result->getTaxRate(), 0.0);
    }

    /**
     * @test
     */
    public function idAddsNettPricesWithSameTaxTest(): void
    {
        $A = Price\Cents::buildByNett($this->currencySymbol, 10000, 20);
        $B = Price\Cents::buildByNett($this->currencySymbol, 20000, 20);

        $result = $A->add($B);

        $this->assertEqualsWithDelta(100 + 200, $result->getNett(), 0.0);
        $this->assertEqualsWithDelta(360, $result->getGross(), 0.0);
        $this->assertEqualsWithDelta(20, $result->getTaxRate(), 0.0);
    }

    /**
     * @test
     */
    public function itAddsGrossPricesWithDifferentTaxTest(): void
    {
        $A = Price\Cents::buildByGross($this->currencySymbol, 10000, 20);
        $B = Price\Cents::buildByGross($this->currencySymbol, 20000, 10);

        $result = $A->add($B);

        $this->assertEqualsWithDelta(26514, $result->toCents()->getNett(), 0.0);
        $this->assertEqualsWithDelta(10000 + 20000, $result->toCents()->getGross(), 0.0);
    }

    /**
     * @test
     */
    public function itAddsNettPricesWithDifferentTaxTest(): void
    {
        $A = Price\Cents::buildByNett($this->currencySymbol, 10000, 20);
        $B = Price\Cents::buildByNett($this->currencySymbol, 20000, 10);

        $result = $A->add($B);

        $this->assertEqualsWithDelta(100 + 200, $result->getNett(), 0.0);
        $this->assertEqualsWithDelta(340, $result->getGross(), 0.0);
    }

    /**
     * @test
     */
    public function itSubtractsGrossPricesWithSameTaxTest(): void
    {
        $A = Price\Cents::buildByGross($this->currencySymbol, 10000, 20);
        $B = Price\Cents::buildByGross($this->currencySymbol, 20000, 20);

        $result = $B->subtract($A);

        $this->assertEqualsWithDelta(8334, $result->toCents()->getNett(), 0.0);
        $this->assertEqualsWithDelta(20000 - 10000, $result->toCents()->getGross(), 0.0);
    }

    /**
     * @test
     */
    public function itSubtractsNettPricesWithSameTaxTest(): void
    {
        $A = Price\Cents::buildByNett($this->currencySymbol, 10000, 20);
        $B = Price\Cents::buildByNett($this->currencySymbol, 20000, 20);

        $result = $B->subtract($A);

        $this->assertEqualsWithDelta(200 - 100, $result->getNett(), 0.0);
        $this->assertEqualsWithDelta(120, $result->getGross(), 0.0);
    }

    /**
     * @test
     */
    public function itSubtractsGrossPricesWithDifferentTaxTest(): void
    {
        $A = Price\Cents::buildByGross($this->currencySymbol, 10000, 20);
        $B = Price\Cents::buildByGross($this->currencySymbol, 20000, 10);

        $result = $B->subtract($A);

        $this->assertEqualsWithDelta(9849, $result->toCents()->getNett(), 0.0);
        $this->assertEqualsWithDelta(20000 - 10000, $result->toCents()->getGross(), 0.0);
    }

    /**
     * @test
     */
    public function itSubtractsNettPricesWithDifferentTaxTest(): void
    {
        $A = Price\Cents::buildByNett($this->currencySymbol, 10000, 10);
        $B = Price\Cents::buildByNett($this->currencySymbol, 20000, 20);

        $result = $B->subtract($A);

        $this->assertEqualsWithDelta(200 - 100, $result->getNett(), 0.0);
        $this->assertEqualsWithDelta(130, $result->getGross(), 0.0);
    }

    /**
     * @test
     * @dataProvider creatingDataProvider
     *
     * @param int $nett
     * @param int $gross
     * @param int $tax
     */
    public function itBuildsNettTest(int $nett, int $gross, int $tax): void
    {
        $price = Price\Cents::buildByNett($this->currencySymbol, $nett, $tax);
        $this->assertEqualsWithDelta($gross, $price->toCents()->getGross(), 0.0);
    }

    /**
     * @test
     * @dataProvider creatingDataProvider
     *
     * @param int $nett
     * @param int $gross
     * @param int $tax
     */
    public function itBuildsGrossTest(int $nett, int $gross, int $tax): void
    {
        $price = Price\Cents::buildByGross($this->currencySymbol, $gross, $tax);
        $this->assertEqualsWithDelta($nett, $price->toCents()->getNett(), 0.0);
    }

    /**
     * @test
     * @dataProvider creatingDataProvider
     *
     * @param int $nett
     * @param int $gross
     * @param int $tax
     */
    public function itBuildsPriceTest(int $nett, int $gross, int $tax): void
    {
        $price = Price\Cents::build($this->currencySymbol, $nett, $gross);
        $this->assertEqualsWithDelta($tax, $price->getTaxRate(), 0.0);
    }

    /**
     * @return array
     */
    public function creatingDataProvider(): array
    {
        return [
            [100000, 123000, 23],
            [682927, 840000, 23],
            [317073, 390000, 23],

            [1097561, 1350000, 23],
            [1101600, 1354968, 23],

            [8100, 8748, 8],
        ];
    }

    /**
     * @test
     * @dataProvider addingDataProvider
     *
     * @param int $grossA
     * @param int $grossB
     * @param int $expectedGross
     */
    public function itAddsPricesTest(int $grossA, int $grossB, int $expectedGross): void
    {
        $tax = 5;
        $nettA = intval($grossA / (100 + $tax) * 100);
        $nettB = intval($grossB / (100 + $tax) * 100);

        $A = Price\Cents::build($this->currencySymbol, $nettA, $grossA);
        $B = Price\Cents::build($this->currencySymbol, $nettB, $grossB);

        $this->assertEqualsWithDelta($expectedGross, $A->add($B)->toCents()->getGross(), 0.0);
        $this->assertEqualsWithDelta($expectedGross, $B->add($A)->toCents()->getGross(), 0.0);

        $this->assertEqualsWithDelta($tax, $B->add($A)->getTaxRate(), 0.0);
        $this->assertEqualsWithDelta($tax, $A->add($B)->getTaxRate(), 0.0);

        $this->assertEqualsWithDelta($nettA, $A->toCents()->getNett(), 0.01);
        $this->assertEqualsWithDelta($nettB, $B->toCents()->getNett(), 0.01);
    }

    /**
     * @return array
     */
    public function addingDataProvider(): array
    {
        return [
            [12300,     24600,    36900],
            [3221,      3332,     6553],
        ];
    }

    /**
     * @test
     */
    public function itAddsDifferentCurrenciesTest(): void
    {
        $this->expectException(\LogicException::class);
        $A = Price\Cents::build($this->currencySymbol, 100, 130);
        $B = Price\Cents::build('USD', 300, 330);
        $A->add($B);
    }

    /**
     * @test
     */
    public function isNettGreaterThanGrossTest(): void
    {
        $this->expectException(\LogicException::class);
        Price\Cents::build($this->currencySymbol, 10000, 9000);
    }

    /**
     * @test
     */
    public function isNettSameAsGrossTest(): void
    {
        $price = Price\Cents::build($this->currencySymbol, 10000, 10000);
        $this->assertEqualsWithDelta(0, $price->getTaxRate(), 0.0);
    }

    /**
     * @test
     * @dataProvider isEqualDataProvider
     *
     * @param int  $nettA
     * @param int  $grossA
     * @param int  $nettB
     * @param int  $grossB
     * @param bool $expectIsEqual
     */
    public function isEqualTest(int $nettA, int $grossA, int $nettB, int $grossB, bool $expectIsEqual): void
    {
        $A = Price\Cents::build($this->currencySymbol, $nettA, $grossA);
        $B = Price\Cents::build($this->currencySymbol, $nettB, $grossB);

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
            [10000,    12300,     10000,     12300,     true],
            [10000,    12300,     10001,     12302,     false],
            [10000,    12300,     1000014,   1230021,   false],
        ];
    }

    /**
     * @test
     */
    public function multiplyTest(): void
    {
        $price = Price\Cents::build($this->currencySymbol, 12000, 15000);
        $result = $price->multiply(5);

        $this->assertEqualsWithDelta(60000, $result->toCents()->getNett(), 0.0);
        $this->assertEqualsWithDelta(75000, $result->toCents()->getGross(), 0.0);
        $this->assertEqualsWithDelta($this->currencySymbol, $result->getCurrencySymbol(), 0.0);
    }

    /**
     * @test
     */
    public function multiplyWithSpecificPriceTest(): void
    {
        $price = Price\Cents::build($this->currencySymbol, 136, 167);
        $result = $price->multiply(141);

        $result = clone $result;

        $this->assertEqualsWithDelta(19144, $result->toCents()->getNett(), 0.0);
        $this->assertEqualsWithDelta(23547, $result->toCents()->getGross(), 0.0);
        $this->assertEqualsWithDelta($this->currencySymbol, $result->getCurrencySymbol(), 0.0);
        $this->assertEqualsWithDelta(23, $result->getTaxRate(), 0.0);
    }

    /**
     * @test
     */
    public function divideTest(): void
    {
        $price = Price\Cents::buildByGross($this->currencySymbol, 23329, 23);
        $price = $price->divide(3);
        $this->assertEqualsWithDelta(6322, $price->toCents()->getNett(), 0.0);
        $this->assertEqualsWithDelta(7776, $price->toCents()->getGross(), 0.0);
        $this->assertEqualsWithDelta(23, $price->getTaxRate(), 0.0);
    }

    /**
     * @test
     */
    public function divideWithSpecificPrice(): void
    {
        $price = Price\Cents::build($this->currencySymbol, 67, 82);
        $price = $price->divide(1);

        $this->assertEqualsWithDelta(67, $price->toCents()->getNett(), 0.0);
        $this->assertEqualsWithDelta(82, $price->toCents()->getGross(), 0.0);
        $this->assertEqualsWithDelta(22, $price->getTaxRate(), 0.0);
    }

    /**
     * @test
     */
    public function addEmptyToNonEmptyTest(): void
    {
        $A = Price\Cents::buildEmpty($this->currencySymbol);
        $B = Price\Cents::buildByGross($this->currencySymbol, 1050, 19);

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
            Price\Cents::buildEmpty($this->currencySymbol),
            Price\Cents::buildEmpty($this->currencySymbol),
        ];

        $total = Price\Cents::buildEmpty($this->currencySymbol);

        foreach ($list as $priceToAdd) {
            $total = $total->add($priceToAdd);
        }

        $this->assertEqualsWithDelta(0, $total->toCents()->getGross(), 0.0);
        $this->assertEqualsWithDelta(0, $total->toCents()->getNett(), 0.0);
        $this->assertEqualsWithDelta($this->currencySymbol, $total->getCurrency(), 0.0);
    }

    /**
     * @test
     */
    public function multiplyByZeroTest(): void
    {
        $price = Price\Cents::buildByNett($this->currencySymbol, 1050, 19);

        $results = $price->multiply(0);

        $this->assertEqualsWithDelta(0, $results->toCents()->getNett(), 0.0);
        $this->assertEqualsWithDelta(0, $results->toCents()->getGross(), 0.0);
        $this->assertEqualsWithDelta(0, $results->getTaxRate(), 0.0);
    }
}
