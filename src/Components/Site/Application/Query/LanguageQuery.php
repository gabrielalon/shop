<?php

namespace App\Components\Site\Application\Query;

use App\Components\Site\Application\Query\Model\LanguageCollection;
use App\System\Messaging\Query\Query;

interface LanguageQuery extends Query
{
    /**
     * @return LanguageCollection
     */
    public function findAllSupportedLanguages(): LanguageCollection;
}
