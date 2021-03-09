<?php

namespace App\Components\Site\Application\Query\Model;

class CountryCollection extends \ArrayIterator
{
    /**
     * @param Country $country
     */
    public function add(Country $country): void
    {
        $this->offsetSet($country->code(), $country);
    }

    /**
     * @return Country[]
     */
    public function all(): array
    {
        return $this->getArrayCopy();
    }
}
