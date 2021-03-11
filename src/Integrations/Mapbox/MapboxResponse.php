<?php

namespace App\Integrations\Mapbox;

abstract class MapboxResponse extends \ArrayIterator
{
    protected string $json;
    protected array $info;
    protected array $body = [];
    protected array $headers = [];

    /**
     * Constructor, parses return values from mapbox::request().
     *
     * @param array $apiResponse The JSON response String returned by Mapbox
     */
    public function __construct(array $apiResponse = [])
    {
        try {
            $this->json = $apiResponse['body']; //raw json
            $this->body = json_decode($apiResponse['body'], true);
            $this->info = $apiResponse['info'];
            $this->headers = $apiResponse['headers'];
            $this->parseResponse();
            parent::__construct($apiResponse);
        } catch (\Exception $e) {
            //add note about json encoding borking here
            throw $e;
        }
    }

    /**
     * Parses the entire response, incl metadata.
     *
     * @return void
     */
    abstract protected function parseResponse(): void;

    /**
     * Get HTTP response code.
     *
     * @return int
     */
    final public function getResponseCode(): int
    {
        return $this->info['code'];
    }

    /**
     * Test for success (200 status return)
     * Note this tests for a successful http call, not a successful program operation.
     */
    final public function success(): bool
    {
        return 200 === $this->info['code'];
    }

    /**
     * Get the entire JSON response from Mapbox.
     *
     * @return string
     */
    final public function json(): string
    {
        return $this->json;
    }

    /**
     * Gets count of elements returned in this page of result set (not total count).
     *
     * @return int
     */
    final public function size(): int
    {
        return count($this);
    }

    /**
     * Subclasses of MapboxResponse must provide access to the original JSON
     * representation of Mapbox's response. Alias for getJson().
     *
     * @return string
     */
    final public function toString(): string
    {
        return $this->json();
    }

    /**
     * Get url-decoded request string, does not include auth.
     *
     * @return string
     */
    final public function getRequest(): string
    {
        return $this->info['request']['unencoded'];
    }

    /**
     * Get url-encoded request string, does not include auth.
     *
     * @return string
     */
    final public function getRawRequest(): string
    {
        return $this->info['request']['encoded'];
    }

    /**
     * Get http headers returned by Mapbox.
     *
     * @return array
     */
    final public function getHeaders(): array
    {
        return $this->headers;
    }

    /**
     * Get information on the call.
     *
     * @return array
     */
    final public function info(): array
    {
        return $this->info;
    }
}
