<?php

namespace App\Integrations\Mapbox;

/**
 * Identical to a MapboxResponse but contains additional methods/properties for working with returned data.
 *
 * @author twbell
 * @license Apache 2.0
 */
class GeocodeResponse extends MapboxResponse
{
    protected $resultCount; //int
    protected $attribution; //str
    protected $type; //str
    protected $query; //array
    protected $features; //str

    /**
     * Parses JSON as array and assigns object values.
     *
     * @param string json JSON returned from API
     */
    protected function parseResponse()
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
     */
    public function getData()
    {
        return $this->features;
    }

    /**
     * Gets count.
     */
    public function getCount()
    {
        return $this->resultCount;
    }

    /**
     * Gets attribution.
     */
    public function getAttribution()
    {
        return $this->attribution;
    }

    /**
     * Assigns data element to object for iterator.
     *
     * @param array data The data array from API response
     */
    protected function assignData($data)
    {
        if ($data) {
            //assign data to iterator
            foreach ($data as $index => $datum) {
                $this[$index] = $datum;
            }
        }
    }
}
