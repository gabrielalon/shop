<?php

namespace App\System\Money;

abstract class Discount
{
    /** @var float */
    protected $value;
    /** @var DiscountEnum */
    private $type;

    /**
     * Discount constructor.
     *
     * @param float $value
     */
    public function __construct(float $value)
    {
        $this->type = $this->initType();
        $this->value = $value;
    }

    /**
     * @return DiscountEnum
     */
    abstract protected function initType(): DiscountEnum;

    /**
     * @return string
     */
    final public function getType(): string
    {
        return $this->type->getValue();
    }

    /**
     * @param Price $price
     *
     * @return Price
     */
    abstract public function apply(Price $price): Price;
}
