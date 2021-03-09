<?php

namespace App\System\Valuing\Option;

use App\System\Valuing\VO;
use InvalidArgumentException;

abstract class Enum extends VO
{
    /**
     * {@inheritdoc}
     */
    protected function guard($value): void
    {
        if (false === in_array($value, $this->validValues(), true)) {
            throw new InvalidArgumentException('Invalid Value enum: '.$value);
        }
    }

    /**
     * @return array
     */
    abstract protected function validValues(): array;
}
