<?php

namespace App\Components\Site\Infrastructure\Query\Model;

use App\Components\Site\Application\Query\Model\Country;
use App\Components\Site\Infrastructure\Entity\Country as CountryEntity;

class CountryFactory
{
    /**
     * @param CountryEntity $country
     *
     * @return Country
     */
    public function build(CountryEntity $country): Country
    {
        return new Country($country->code, $country->native_name);
    }
}
