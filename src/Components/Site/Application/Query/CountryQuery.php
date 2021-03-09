<?php

namespace App\Components\Site\Application\Query;

use App\Components\Site\Application\Query\Model\CountryCollection;
use App\System\Messaging\Query\Query;

interface CountryQuery extends Query
{
    /**
     * @return CountryCollection
     */
    public function findCountryCollection(): CountryCollection;
}
