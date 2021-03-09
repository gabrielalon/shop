<?php

namespace App\Components\Site;

use App\Components\Site\Application\Query\CountryQuery;
use App\Components\Site\Application\Query\LanguageQuery;
use App\System\Messaging\MessageBus;
use App\System\Messaging\Query\Query;

class Site
{
    /** @var MessageBus */
    private $messageBus;

    /**
     * Site constructor.
     *
     * @param MessageBus $messageBus
     */
    public function __construct(MessageBus $messageBus)
    {
        $this->messageBus = $messageBus;
    }

    /**
     * @return CountryQuery|Query
     */
    public function askCountry(): CountryQuery
    {
        return $this->messageBus->query(CountryQuery::class);
    }

    /**
     * @return LanguageQuery|Query
     */
    public function askLanguage(): LanguageQuery
    {
        return $this->messageBus->query(LanguageQuery::class);
    }
}
