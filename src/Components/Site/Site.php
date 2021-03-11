<?php

namespace App\Components\Site;

use App\Components\Site\Application\Query\CountryQuery;
use App\Components\Site\Application\Query\LanguageQuery;
use App\System\Messaging\MessageBus;

final class Site
{
    /** @var MessageBus */
    private MessageBus $messageBus;

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
     * @return CountryQuery
     */
    public function askCountry(): CountryQuery
    {
        $query = $this->messageBus->query(CountryQuery::class);

        assert($query instanceof CountryQuery);

        return $query;
    }

    /**
     * @return LanguageQuery
     */
    public function askLanguage(): LanguageQuery
    {
        $query = $this->messageBus->query(LanguageQuery::class);

        assert($query instanceof LanguageQuery);

        return $query;
    }
}
