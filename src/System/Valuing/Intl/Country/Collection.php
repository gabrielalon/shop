<?php

namespace App\System\Valuing\Intl\Country;

use ArrayIterator;
use InvalidArgumentException;

final class Collection extends ArrayIterator
{
    /**
     * @param Code $code
     */
    public function add(Code $code): void
    {
        $this->offsetSet($code->toString(), $code);
    }

    /**
     * @param Collection $other
     *
     * @return bool
     */
    public function equals($other): bool
    {
        if (false === $other instanceof self) {
            return false;
        }

        /** @var Code $code */
        foreach ($this->getArrayCopy() as $code) {
            try {
                $otherValue = $other->get($code->toString());
            } catch (InvalidArgumentException $e) {
                return false;
            }

            if (false === $code->equals($otherValue)) {
                return false;
            }
        }

        return true;
    }

    /**
     * @param string $code
     *
     * @return Code
     */
    public function get(string $code): Code
    {
        if (false === $this->offsetExists($code)) {
            throw new InvalidArgumentException('Not found Country code: '.$code, $code);
        }

        return $this->offsetGet($code);
    }
}
