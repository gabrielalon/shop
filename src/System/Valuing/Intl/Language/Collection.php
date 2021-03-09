<?php

namespace App\System\Valuing\Intl\Language;

use App\System\Valuing\Char;
use ArrayIterator;
use InvalidArgumentException;

final class Collection extends ArrayIterator
{
    /**
     * @param Code      $locale
     * @param Char\Char $text
     */
    public function add(Code $locale, Char\Char $text): void
    {
        $this->offsetSet($locale->toString(), $text);
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

        /**
         * @var string
         * @var Char\Text $text
         */
        foreach ($this->getArrayCopy() as $locale => $text) {
            try {
                $otherValue = $other->get($locale);
            } catch (InvalidArgumentException $e) {
                return false;
            }

            if (false === $text->equals($otherValue)) {
                return false;
            }
        }

        return true;
    }

    /**
     * @param string $locale
     *
     * @return Char\Text
     */
    public function get(string $locale): Char\Char
    {
        if (false === $this->offsetExists($locale)) {
            throw new InvalidArgumentException('Not Found Locale string: '.$locale, $locale);
        }

        return $this->offsetGet($locale);
    }
}
