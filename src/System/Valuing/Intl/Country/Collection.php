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
     * @param mixed $other
     *
     * @return bool
     */
    public function equals(mixed $other): bool
    {
        if (false === $other instanceof self) {
            return false;
        }

        foreach ($this->getArrayCopy() as $code) {
            assert($code instanceof Code);

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
            throw new InvalidArgumentException('Not found Country code: '.$code, 500);
        }

        return $this->offsetGet($code);
    }
}
