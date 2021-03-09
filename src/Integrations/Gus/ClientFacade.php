<?php

namespace App\Integrations\Gus;

use GusApi\Exception\InvalidUserKeyException;
use GusApi\Exception\NotFoundException;
use GusApi\GusApi;
use GusApi\SearchReport;

class ClientFacade
{
    /** @var GusApi */
    private $client;

    /**
     * ClientFacade constructor.
     *
     * @param string $key
     */
    public function __construct(string $key)
    {
        $this->client = new GusApi($key);
    }

    /**
     * @param string $nip
     *
     * @return SearchReport
     *
     * @throws InvalidUserKeyException|NotFoundException
     */
    public function searchByNip(string $nip): SearchReport
    {
        return current($this->client->getByNip($nip));
    }
}
