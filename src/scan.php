<?php
/**
 * Created by PhpStorm.
 * User: PAVEL
 * Date: 3.2.2016
 * Time: 19:31
 */

require("/vendor/autoload.php");

$client = new \GuzzleHttp\Client();

$csv = \League\Csv\Reader::createFromPath($argv[1]);

echo($argv[0] . PHP_EOL);

foreach ($csv as $csvRow) {
    try {
        $httpResponse = $client->get($csvRow[0]);

        if ($httpResponse->getStatusCode() >= 400) {
            throw new Exception;
        }

        echo($csvRow[0] . " - " . $httpResponse->getStatusCode() . PHP_EOL);

    } catch (\Exception $e) {
        echo $csvRow[0] . PHP_EOL;
    }
}

