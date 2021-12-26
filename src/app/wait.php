<?php
require __DIR__ . '/../vendor/autoload.php';

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

use Amp\Parallel\Worker\DefaultPool;
use function Amp\ParallelFunctions\parallelMap;
use function Amp\Promise\wait;

$script_time_start = microtime(true);

$promises = parallelMap(range(1, 50), function ($index) {
    echo sprintf("Request: %d.%s", $index, PHP_EOL);

    $time_start = microtime(true);

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'http://172.18.0.3:80/api/dice/play');
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Accept:application/json']);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $output = curl_exec($ch);
    
    if (curl_errno($ch)) {
        echo 'Curl error: '.curl_error($ch);
    }

    curl_close($ch);
    echo $output . PHP_EOL;

    $total_time = number_format(microtime(true) - $time_start, 2);
    echo sprintf("Request %d total execution time in seconds: %f.%s", $index, $total_time, PHP_EOL);
    return [$index => $total_time];
});

wait($promises);

$scritp_total_time = number_format(microtime(true) - $script_time_start, 2);
echo sprintf("Script total execution time in seconds: %f.%s", $scritp_total_time, PHP_EOL);
