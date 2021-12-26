<?php
require __DIR__ . '/../vendor/autoload.php';

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

use Amp\Http\Client\HttpClientBuilder;
use Amp\Http\Client\Request;
use Amp\Loop;

$script_time_start = microtime(true);

Loop::run(function () {

    $range = range(0, 49);
    foreach ($range as $i) {
        $time_start = microtime(true);

        echo sprintf("Request: %d %s", $i+1, PHP_EOL);

        $client = HttpClientBuilder::buildDefault();
        $request = new Request('http://172.18.0.3:80/api/dice/play');
        $request->setHeader('Accept', 'application/json');
        $response = yield $client->request($request);

        echo yield $response->getBody()->buffer(); echo PHP_EOL;

        $total_time = number_format(microtime(true) - $time_start, 2);
        echo sprintf("Request %d total execution time in seconds: %f.%s", $i, $total_time, PHP_EOL);
    }
});

$scritp_total_time = number_format(microtime(true) - $script_time_start, 2);
echo sprintf("Script total execution time in seconds: %f.%s", $scritp_total_time, PHP_EOL);
