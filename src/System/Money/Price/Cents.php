<?php

namespace App\System\Money\Price;

use App\System\Money\Currency;
use App\System\Money\Price;
use LogicException;

class Cents
{
    /** @var Price */
    private $price;

    /**
     * PriceCent constructor.
     *
     * @param Price $price
     */
    private function __construct(Price $price)
    {
        $this->price = $price;
    }

    /**
     * @param Price $price
     *
     * @return Cents
     */
    public static function fromPrice(Price $price): Cents
    {
        return new self($price);
    }

    /**
     * @param string $currencySymbol
     * @param int    $nett
     * @param int    $gross
     *
     * @return Price
     *
     * @throws LogicException
     */
    public static function build(string $currencySymbol, int $nett = 0, int $gross = 0): Price
    {
        $currency = new Currency($currencySymbol);
        $newNett = $nett / 10 ** $currency->getPrecision();
        $newGross = $gross / 10 ** $currency->getPrecision();

        return Price::build($currencySymbol, $newNett, $newGross);
    }

    /**
     * @param string $currencySymbol
     *
     * @return Price
     */
    public static function buildEmpty(string $currencySymbol): Price
    {
        return Price::buildEmpty($currencySymbol);
    }

    /**
     * @param string $currencySymbol
     * @param int    $nett
     * @param int    $tax
     *
     * @return Price
     */
    public static function buildByNett(string $currencySymbol, int $nett, int $tax): Price
    {
        $currency = new Currency($currencySymbol);
        $newNett = $nett / 10 ** $currency->getPrecision();

        return Price::buildByNett($currencySymbol, $newNett, $tax);
    }

    /**
     * @param string $currencySymbol
     * @param int    $gross
     * @param int    $tax
     *
     * @return Price
     */
    public static function buildByGross(string $currencySymbol, int $gross, int $tax): Price
    {
        $currency = new Currency($currencySymbol);
        $newGross = $gross / 10 ** $currency->getPrecision();

        return Price::buildByGross($currencySymbol, $newGross, $tax);
    }

    /**
     * @param array $data
     *
     * @return Price
     *
     * @throws \InvalidArgumentException
     */
    public static function buildByData(array $data): Price
    {
        return Price::buildByData($data);
    }

    /**
     * @return int
     */
    public function getTaxDiff(): int
    {
        return max(0, $this->getGross() - $this->getNett());
    }

    /**
     * @return int
     */
    public function getGross(): int
    {
        return (int) ($this->price->getGross() * 10 ** $this->price->getCurrency()->getPrecision());
    }

    /**
     * @return int
     */
    public function getNett(): int
    {
        return (int) ($this->price->getNett() * 10 ** $this->price->getCurrency()->getPrecision());
    }

    /**
     * @param Price $price
     *
     * @return bool
     */
    public function isLowerThan(Price $price): bool
    {
        return $this->price->isLowerThan($price);
    }

    /**
     * @param Price $price
     *
     * @return bool
     */
    public function isEqLowerThan(Price $price): bool
    {
        return $this->price->isEqLowerThan($price);
    }

    /**
     * @param Price $price
     *
     * @return bool
     */
    public function isGreaterThan(Price $price): bool
    {
        return $this->price->isGreaterThan($price);
    }

    /**
     * @param Price $price
     *
     * @return bool
     */
    public function isEqGreaterThan(Price $price): bool
    {
        return $this->price->isEqGreaterThan($price);
    }

    /**
     * @param Price $price
     *
     * @return bool
     */
    public function isEqual(Price $price): bool
    {
        return $this->price->isEqual($price);
    }

    /**
     * @return bool
     */
    public function isEmpty(): bool
    {
        return $this->price->isEmpty();
    }

    /**
     * @param Price $priceToAdd
     *
     * @return Price
     *
     * @throws LogicException
     */
    public function add(Price $priceToAdd): Price
    {
        return $this->price->add($priceToAdd);
    }

    /**
     * @param Price $priceToSubtract
     *
     * @return Price
     *
     * @throws LogicException
     */
    public function subtract(Price $priceToSubtract): Price
    {
        return $this->price->subtract($priceToSubtract);
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return $this->price->toArray();
    }

    /**
     * @return Price
     */
    public function toPrice(): Price
    {
        return $this->price;
    }
}
