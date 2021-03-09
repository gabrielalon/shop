<?php

namespace App\System\Money;

use function sprintf;
use Webmozart\Assert\Assert as Assertion;

final class Price
{
    /** @var Money */
    private $nett;

    /** @var Money */
    private $gross;

    /** @var Currency */
    private $currency;

    /** @var Tax */
    private $tax;

    /**
     * @param string $currencySymbol
     * @param float  $nett
     * @param float  $gross
     *
     * @throws \LogicException
     */
    private function __construct(string $currencySymbol, float $nett = 0.0, float $gross = 0.0)
    {
        $this->tax = Tax::build($nett, $gross);
        $this->currency = new Currency($currencySymbol);

        $this->nett = new Money($nett);
        $this->gross = new Money($gross);

        if ($this->nett->isGreaterThan($this->gross)) {
            throw new \LogicException('Nett must not be greater than gross');
        }
    }

    /**
     * @param string $currencySymbol
     * @param float  $nett
     * @param float  $gross
     *
     * @return Price
     *
     * @throws \LogicException
     */
    public static function build(string $currencySymbol, float $nett = 0.0, float $gross = 0.0): Price
    {
        return new self($currencySymbol, $nett, $gross);
    }

    /**
     * @param string    $currencySymbol
     * @param float|int $nett
     * @param int       $tax
     *
     * @return Price
     */
    public static function buildByNett(string $currencySymbol, $nett, int $tax): Price
    {
        return new self($currencySymbol, $nett, (new Tax($tax))->calculateGross($nett));
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
        Assertion::keyExists($data, 'currency_symbol', 'Expected the key %s to exist in price data.');
        Assertion::keyExists($data, 'gross', 'Expected the key %s to exist in price data.');
        Assertion::keyExists($data, 'tax', 'Expected the key %s to exist in price data.');

        return self::buildByGross($data['currency_symbol'], $data['gross'], $data['tax']);
    }

    /**
     * @return Price\Cents
     */
    public function toCents(): Price\Cents
    {
        return Price\Cents::fromPrice($this);
    }

    /**
     * @return float
     */
    public function getTaxDiff(): float
    {
        return max(0.0, $this->getGross() - $this->getNett());
    }

    /**
     * @return float
     */
    public function getGross(): float
    {
        return round($this->gross->getValue(), $this->currency->getPrecision());
    }

    /**
     * @return float
     */
    public function getNett(): float
    {
        return round($this->nett->getValue(), $this->currency->getPrecision());
    }

    /**
     * @param Price $price
     *
     * @return bool
     */
    public function isLowerThan(Price $price): bool
    {
        return $this->getGross() < $price->getGross();
    }

    /**
     * @param Price $price
     *
     * @return bool
     */
    public function isEqLowerThan(Price $price): bool
    {
        return $this->getGross() <= $price->getGross();
    }

    /**
     * @param Price $price
     *
     * @return bool
     */
    public function isEqGreaterThan(Price $price): bool
    {
        return $this->getGross() >= $price->getGross();
    }

    /**
     * @param Price $price
     *
     * @return bool
     */
    public function isEqual(Price $price): bool
    {
        if (false === $this->compareCurrencies($this, $price)) {
            return false;
        }

        $isGrossEqual = $this->getGross() === $price->getGross();
        $isNettEqual = $this->getNett() === $price->getNett();

        return $isGrossEqual && $isNettEqual;
    }

    /**
     * @param Price $A
     * @param Price $B
     *
     * @return bool
     */
    private function compareCurrencies(Price $A, Price $B): bool
    {
        return $A->getCurrency()->isEqual($B->getCurrency());
    }

    /**
     * @return Currency
     */
    public function getCurrency(): Currency
    {
        return $this->currency;
    }

    /**
     * @param Price $priceToAdd
     *
     * @return Price
     *
     * @throws \LogicException
     */
    public function add(Price $priceToAdd): Price
    {
        $currency = $this->buildCurrency($this, $priceToAdd);
        $newGross = $this->getGross() + $priceToAdd->getGross();
        $newNett = $this->getNett() + $priceToAdd->getNett();

        return new self((string) $currency, $newNett, $newGross);
    }

    /**
     * @param Price $A
     * @param Price $B
     *
     * @return Currency
     *
     * @throws \LogicException
     */
    private function buildCurrency(Price $A, Price $B): Currency
    {
        $this->checkCurrencies($A->getCurrency(), $B->getCurrency());

        return $A->getCurrency();
    }

    /**
     * @param Currency $currencyA
     * @param Currency $currencyB
     *
     * @throws \LogicException
     */
    private function checkCurrencies(Currency $currencyA, Currency $currencyB): void
    {
        if (false === $currencyA->isEqual($currencyB)) {
            $message = sprintf(
                'Can not operate on different currencies ("%s" and "%s")',
                (string) $currencyA,
                (string) $currencyB
            );

            throw new \LogicException($message);
        }
    }

    /**
     * @param Price $priceToSubtract
     *
     * @return Price
     *
     * @throws \LogicException
     */
    public function subtract(Price $priceToSubtract): Price
    {
        $currency = $this->buildCurrency($this, $priceToSubtract);

        if ($this->isGreaterThan($priceToSubtract)) {
            $newGross = $this->getGross() - $priceToSubtract->getGross();
            $newNett = $this->getNett() - $priceToSubtract->getNett();

            return new self((string) $currency, $newNett, $newGross);
        }

        return self::buildEmpty((string) $currency);
    }

    /**
     * @param Price $price
     *
     * @return bool
     */
    public function isGreaterThan(Price $price): bool
    {
        return $this->getGross() > $price->getGross();
    }

    /**
     * @param string $currencySymbol
     *
     * @return Price
     */
    public static function buildEmpty(string $currencySymbol): Price
    {
        static $emptyPrice = [];

        if (array_key_exists($currencySymbol, $emptyPrice)) {
            return $emptyPrice[$currencySymbol];
        }

        return $emptyPrice[$currencySymbol] = new self($currencySymbol, 0.0, 0.0);
    }

    /**
     * @return bool
     */
    public function isEmpty(): bool
    {
        return 0.0 === $this->gross->getValue() && 0.0 === $this->nett->getValue();
    }

    /**
     * @param int|float $times
     *
     * @return Price
     */
    public function multiply($times): Price
    {
        if ($times < 0) {
            throw new \LogicException('Multiply param must greater than 0');
        }

        $newGross = $this->getGross() * $times;
        $currency = $this->getCurrency();

        return self::buildByGross((string) $currency, $newGross, $this->getTaxRate());
    }

    /**
     * @param string    $currencySymbol
     * @param float|int $gross
     * @param int       $tax
     *
     * @return Price
     */
    public static function buildByGross(string $currencySymbol, $gross, int $tax): Price
    {
        return new self($currencySymbol, (new Tax($tax))->calculateNett($gross), $gross);
    }

    /**
     * @return int
     */
    public function getTaxRate(): int
    {
        return $this->getTax()->getValue();
    }

    /**
     * @return Tax
     */
    private function getTax(): Tax
    {
        return $this->tax;
    }

    /**
     * @param int $times
     *
     * @return Price
     */
    public function divide(int $times): Price
    {
        if ($times <= 0) {
            throw new \LogicException('Divide factor must be positive and greater than zero');
        }

        $newGross = $this->getGross() / $times;
        $currency = $this->getCurrency();

        return self::buildByGross((string) $currency, $newGross, $this->getTaxRate());
    }

    /**
     * @param string $locale
     * @param string $country
     * @param string $format
     * @param string $encoding
     *
     * @return string
     */
    public function toString(
        string $locale,
        string $country,
        string $format = '%.2n',
        string $encoding = 'UTF-8'
    ): string {
        $currentLocale = setlocale(LC_ALL, 0);

        setlocale(LC_MONETARY, sprintf('%s_%s.%s', $locale, $country, $encoding));
        $price = money_format($format, $this->getNett());
        setlocale(LC_MONETARY, $currentLocale);

        return $price;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'currency_symbol' => $this->getCurrencySymbol(),
            'gross' => $this->getGross(),
            'tax' => $this->getTaxRate(),
        ];
    }

    /**
     * @return string
     */
    public function getCurrencySymbol(): string
    {
        return (string) $this->currency;
    }
}
