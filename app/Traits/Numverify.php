<?php

namespace App\Traits;

trait Numverify
{

    /**
     * The base url for the numverify Api
     * @var string
     */
    protected $url = 'http://apilayer.net/api/validate?';

    /**
     * The api key for the numverify Api
     * @var string
     */
    protected $key;

    /**
     * The country code for the numverify Api, we are only interested in UK numbers
     * @var string
     */
    protected $countryCode = 'GB';

    /**
     * The 'format' url parameter for the numverify Api
     * @var integer
     */
    protected $format = 1;


    public function __construct()
    {

    }

    /**
     * Lookup number using numverify api
     * @param string $phoneNumber
     * @return array
     */
    private function search($phoneNumber)
    {
        try {
            $client = new \GuzzleHttp\Client();
            $response = $client->request('GET', $this->buildUrl($phoneNumber));
            $results = json_decode($response->getBody()->getContents(), true);

            return $results;

        } catch(\GuzzleHttp\Exception\ClientException $e) {
            Log::error('Numverify Client Exception', ['message' => $e->getMessage()]);
        } catch (\Guzzle\Http\Exception\BadResponseException $e) {
            Log::error('Numverify Bad Response Exception', ['message' => $e->getMessage()]);
        }
    }

    /**
     * Create url string from the base url and get parameters
     * @param string $phoneNumber
     * @return string
     */
    public function buildUrl($phoneNumber)
    {
        $params = $this->getParams($phoneNumber);
        $url = $this->url . join('&', $params);

        return $url;
    }

    /**
     * Create parameter string to be used for numverify api request
     * @param string $phoneNumber
     * @return string
     */
    private function getParams($phoneNumber)
    {
        $params = [];
        $params[] = 'access_key=' . $this->key;
        $params[] = 'number=' . $phoneNumber;
        $params[] = 'country_code=' . $this->countryCode;
        $params[] = 'format=' . $this->format;

        return $params;
    }

}
