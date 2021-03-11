<?php

namespace App\Integrations\Mapbox;

final class Mapbox
{
    /** @var string */
    private string $home = 'https://api.mapbox.com'; //URL base

    /** @var string */
    private string $driverVersion = 'mapbox-php-driver-v0.1.0';  //current version of the php wrapper

    /** @var string[] */
    private array $versions = ['geocoder' => 'v5']; //versions for endpoint

    /** @var bool */
    private bool $debug = false; //debug flag

    /** @var bool */
    private bool $permanentGeocodes = false; //changes geocding endpoint when flipped

    /** @var MapboxConfig */
    private MapboxConfig $config;

    /**
     * Mapbox constructor.
     *
     * @param MapboxConfig $config
     */
    public function __construct(MapboxConfig $config)
    {
        $this->config = $config;
    }

    /**
     * @return string
     */
    private function getGeocoderDataSet(): string
    {
        if (true === $this->permanentGeocodes) {
            $dataSet = 'mapbox.places-permanent';
        } else {
            $dataSet = 'mapbox.places';
        }

        return $dataSet;
    }

    /**
     * @param string $query
     *
     * @return string
     */
    private function urlForGeocode(string $query): string
    {
        return $this->home.'/geocoding/'.$this->versions['geocoder'].'/'.$this->getGeocoderDataSet().'/'.urlencode($query).'.json';
    }

    /**
     * @param float $longitude
     * @param float $latitude
     *
     * @return string
     */
    private function urlForReverseGeocode(float $longitude, float $latitude): string
    {
        return $this->home.'/geocoding/'.$this->versions['geocoder'].'/'.$this->getGeocoderDataSet().'/'.$longitude.','.$latitude.'.json';
    }

    /**
     * Geocodes by returning a response containing the address nearest a given point.
     *
     * @param string|null $query     The unstructured address or place-name
     * @param array       $types     containing n of country, region, postcode, place, neighborhood, address, or poi
     * @param array       $proximity with keys 'longitude' , 'latitude'
     *
     * @return GeocodeResponse|null response of a geocode query against Mapbox
     *
     * @throws MapboxApiException
     * @throws \Exception
     */
    public function geocode(?string $query = null, array $types = [], array $proximity = []): ?GeocodeResponse
    {
        $params = [];
        if (empty($query)) {
            return null;
        }
        $url = $this->urlForGeocode($query);
        if (!empty($types)) {
            $params['types'] = $types;
        }
        if (!empty($proximity)) {
            $params['proximity'] = $proximity['longitude'].','.$proximity['latitude'];
        }
        $this->permanentGeocodes = false; //set by default to off

        return new GeocodeResponse($this->request($url, 'GET', $params));
    }

    /**
     * Different endpoint for permanent geocodes.
     *
     * @param string|null $query
     * @param array       $types
     * @param array       $proximity
     *
     * @return GeocodeResponse|null
     *
     * @throws MapboxApiException
     */
    public function geocodePermanent(?string $query = null, array $types = [], array $proximity = []): ?GeocodeResponse
    {
        $this->permanentGeocodes = true;

        return $this->geocode($query, $types, $proximity);
    }

    /**
     * Reverse geocodes by returning a response containing the resolved entities.
     *
     * @param float $longitude point The point for which the nearest address is returned
     * @param float $latitude
     * @param array $types
     *
     * @return GeocodeResponse response of running a reverse geocode query for <tt>point</tt> against Mapbox
     *
     * @throws MapboxApiException
     * @throws \Exception
     */
    public function reverseGeocode(float $longitude, float $latitude, array $types = []): GeocodeResponse
    {
        $params = [];
        $url = $this->urlForReverseGeocode($longitude, $latitude);
        if (!empty($types)) {
            $params['types'] = $types;
        }

        return new GeocodeResponse($this->request($url, 'GET', $params));
    }

    /**
     * Sign the request, perform a curl request and return the results.
     *
     * @param string $urlStr        unsigned URL request
     * @param string $requestMethod
     * @param array  $params
     *
     * @return array ex: array ('headers'=>array(), 'body'=>string)
     *
     * @throws MapboxApiException
     */
    private function request(string $urlStr, string $requestMethod = 'GET', array $params = []): array
    {
        //custom input headers
        $curlOptions[CURLOPT_HTTPHEADER] = [];
        $curlOptions[CURLOPT_HTTPHEADER][] = 'X-Mapbox-Lib: '.$this->driverVersion;
        if ('POST' === $requestMethod) {
            $curlOptions[CURLOPT_HTTPHEADER][] = 'Content-Type: '.'application/x-www-form-urlencoded';
        }

        //request curl returns server headers
        $curlOptions[CURLOPT_RETURNTRANSFER] = 1;
        $curlOptions[CURLOPT_HEADER] = 1;

        //other curl options
        $curlOptions[CURLOPT_CONNECTTIMEOUT] = $this->config->connectionTimeout(); //connection timeout
        $curlOptions[CURLOPT_TIMEOUT] = $this->config->curlTimeout(); //execution timeout
        $curlOptions[CURLOPT_RETURNTRANSFER] = 1; //return contents on success

        //format query parameters and append
        $keyVal = [];
        $formattedParams = null;
        if (count($params) > 0) {
            foreach ($params as $key => $value) {
                if (is_array($value)) {
                    $keyVal[] = $key.'='.implode(',', $value);
                } else {
                    $keyVal[] = $key.'='.$value;
                }
            }
            $formattedParams .= implode('&', $keyVal);
        }

        //url formatting
        if ($formattedParams) {
            $urlStr .= '?'.$formattedParams;
            $url = $urlStr.'&access_token='.$this->config->accessToken();
        } else {
            $url = $urlStr.'?access_token='.$this->config->accessToken();
        }

        //format cURL
        $ch = curl_init($url);
        foreach ($curlOptions as $key => $value) {
            curl_setopt($ch, $key, $value);
        }

        //init metadata
        $info = [];
        $info['request']['encoded'] = $urlStr;
        $info['request']['unencoded'] = urldecode($urlStr);
        $info['driver'] = $this->driverVersion;
        $info['request']['method'] = $requestMethod;

        //make request
        try {
            $callStart = microtime(true);
            $result = curl_exec($ch);
            $callEnd = microtime(true);
        } catch (\Exception $e) {
            //catch client exception
            $info['message'] = "Service exception.  Client did not connect and returned '".$e->getMessage()."'";
            $MapboxE = new MapboxApiException($info);
            throw $MapboxE;
        }

        //add execution time
        $info['request']['time'] = $callEnd - $callStart;

        //extract Mapbox headers
        $headerSize = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
        $header = substr($result, 0, $headerSize);
        $result = substr($result, $headerSize);
        $headers = explode(PHP_EOL, $header);
        $headers = array_filter($headers, 'trim');

        //extract curl info
        $info['code'] = (int) curl_getinfo($ch, CURLINFO_HTTP_CODE);
        if ($params) {
            $info['request']['parameters'] = $params;
        }

        //catch server exception & load up on debug data
        if ($info['code'] >= 400 | $this->debug) {
            //get a boatload of debug data
            $info['headers'] = $headers;
            $info['curl'] = curl_getinfo($ch);
            //write debug info to stderr if debug mode on
            if ($this->debug) {
                $info = array_filter($info); //remove empty elements for readability
                file_put_contents('php://stderr', 'Debug '.print_r($info, true));
            }
            //chuck exception with some helpful errors for the most common codes
            if ($info['code'] >= 400) {
                switch ($info['code']) {
                    case 401:
                    $info['message'] = '401 Unauthorized; check your access token';
                    break;
                    case 403:
                    $info['message'] = '403 Verboten; you do not have access to this resource -- some endpoints require authorization from Mapbox';
                    break;
                 case 429:
                    $info['message'] = '429 Enhance your calm.  Exceeding rate limits -- use this::debug to see server response headers';
                    break;
                case 422:
                    $info['message'] = '422 Unprocessable Entity; check your parameter values, esp swapped lat/lons, because we all do this';
                    break;
                 default:
                    $info['message'] = 'HTTP code '.$info['code'].': use this::debug to see server response headers';
                    break;
                }
                $MapboxE = new MapboxApiException($info);
                throw $MapboxE;
            }
        }

        //close curl
        curl_close($ch);

        //format
        $res['info'] = $info;
        $res['headers'] = $headers;
        $res['body'] = $result;

        return $res;
    }
}
