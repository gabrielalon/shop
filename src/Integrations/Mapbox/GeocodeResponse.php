<?php

namespace App\Integrations\Mapbox;

final class GeocodeResponse extends MapboxResponse
{
    protected int $resultCount;
    protected string $attribution;
    protected string $type;
    protected array $query;
    protected string $features;

    /**
     * Parses JSON as array and assigns object values.
     *
     * json JSON returned from API
     */
    protected function parseResponse(): void
    {
        $this->resultCount = count($this->body['features']);
        $this->attribution = $this->body['attribution'];
        $this->type = $this->body['type'];
        $this->query = $this->body['query'];
        $this->features = $this->body['features'];

        //assign data
        $this->assignData($this->body['features']);
    }

    /**
     * Gets response.
     *
     * @return string
     */
    final public function getData(): string
    {
        return $this->features;
    }

    /**
     * Gets count.
     *
     * @return int
     */
    final public function getCount(): int
    {
        return $this->resultCount;
    }

    /**
     * Gets attribution.
     *
     * @return string
     */
    final public function getAttribution(): string
    {
        return $this->attribution;
    }

    /**
     * Assigns data element to object for iterator.
     *
     * @param array $data The data array from API response
     */
    private function assignData(array $data): void
    {
        if ($data) {
            //assign data to iterator
            foreach ($data as $index => $datum) {
                $this[$index] = $datum;
            }
        }
    }
}
