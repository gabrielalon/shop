<?php

namespace App\System\Money;

final class Currency
{
    /**
     * There exists currencies with different precision
     * but those are extremely uncommon.
     *
     * Full list:
     * https://pl.wikipedia.org/wiki/Jen
     * https://pl.wikipedia.org/wiki/Funt_cypryjski
     * https://pl.wikipedia.org/wiki/Dinar_iracki
     * https://pl.wikipedia.org/wiki/Dinar_jordański
     * https://pl.wikipedia.org/wiki/Dinar_kuwejcki
     * https://pl.wikipedia.org/wiki/Dinar_Bahrajnu
     */
    private const PRECISION = 2;

    /** @var string */
    private $symbol;

    /**
     * Currency constructor.
     *
     * @param string $symbol
     */
    public function __construct(string $symbol)
    {
        $this->symbol = $symbol;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->symbol;
    }

    /**
     * @return int
     */
    public function getPrecision(): int
    {
        return self::PRECISION;
    }

    /**
     * @param Currency $currency
     *
     * @return bool
     */
    public function isEqual(Currency $currency): bool
    {
        return (string) $this === (string) $currency;
    }
}
