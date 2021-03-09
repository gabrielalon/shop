<?php

namespace App\System\Valuing\Number;

use App\System\Valuing\VO;
use InvalidArgumentException;
use Webmozart\Assert\Assert as Assertion;

final class Number extends VO
{
    /**
     * @param int $integer
     *
     * @return Number
     *
     * @throws InvalidArgumentException
     */
    public static function fromInt(int $integer): Number
    {
        return new self($integer);
    }

    /**
     * {@inheritdoc}
     */
    protected function guard($value): void
    {
        Assertion::integer($value, 'Invalid Quantity value: '.$value);
    }
}
