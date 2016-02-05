<?php
/**
 * Created by PhpStorm.
 * User: PAVEL
 * Date: 4.2.2016
 * Time: 14:39
 */

namespace Pavher\Urlscanner\Url;

use GuzzleHttp\Client;

class Scanner
{
    protected $urls;

    protected $httpClient;

    function __construct(array $urls)
    {
        $this->urls = $urls;
        $this->httpClient = new Client();
    }

    public function getInvalidUrls()
    {
        $invalidUrls = [];

        foreach ($this->urls as $url) {
            try {
                $statusCode = $this->getStatusCodeForUrl($url);
            } catch (\Exception $e) {
                $statusCode = 500;
            }

            if ($statusCode >= 400) {
                array_push($invalidUrls,["url" => $url, "status" => $statusCode]);
            }
        }

        return $invalidUrls;
    }

    public function getStatusCodeForUrl($url)
    {
        $httpResponse = $this->httpClient->get($url);
        return $httpResponse->getStatusCode();
    }


}