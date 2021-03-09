<?php

namespace App\System\Money;

use InvalidArgumentException;
use Webmozart\Assert\Assert as Assertion;

final class Tax
{
    /** @var int */
    private $value;

    /**
     * Tax constructor.
     *
     * @param int $tax
     *
     * @throws InvalidArgumentException
     */
    public function __construct(int $tax)
    {
        Assertion::greaterThanEq($tax, 0, 'Given tax value should be greater than %2$s. Got: %s');
        Assertion::lessThanEq($tax, 100, 'Given tax value should be less than %2$s. Got: %s');

        $this->value = $tax;
    }

    /**
     * @param float|int $nett
     * @param float|int $gross
     *
     * @return Tax
     */
    public static function build($nett, $gross): Tax
    {
        if ($nett > 0) {
            $taxValue = (int) round($gross / $nett * 100 - 100, 0);
        } else {
            $taxValue = 0;
        }

        return new Tax($taxValue);
    }

    /**
     * @param float|int $nett
     *
     * @return float
     */
    public function calculateGross($nett): float
    {
        return (float) $nett * ($this->getValue() + 100) / 100;
    }

    /**
     * @return int
     */
    public function getValue(): int
    {
        return $this->value;
    }

    /**
     * @param float|int $gross
     *
     * @return float
     */
    public function calculateNett($gross): float
    {
        return (float) $gross * 100 / ($this->getValue() + 100);
    }
}
