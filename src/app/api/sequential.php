<?php

require __DIR__ . '/../Bag.php';

Bag::debug();

$script_time_start = microtime(true);

$range = range(0, 49);
foreach ($range as $i) {
    echo sprintf("Request: %d %s", $i+1, PHP_EOL);
    sendRequest($i+1);
}

function sendRequest($index): array
{
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
}

$scritp_total_time = number_format(microtime(true) - $script_time_start, 2);
echo sprintf("Script total execution time in seconds: %f.%s", $scritp_total_time, PHP_EOL);
echo sprintf("Script memory usage: %s.%s", Bag::memoryUsageFormatted(), PHP_EOL);
