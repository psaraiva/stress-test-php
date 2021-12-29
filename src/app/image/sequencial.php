<?php

require __DIR__ . '/../Bag.php';

Bag::debug();

$script_time_start = microtime(true);

$range = range(0, 49);
foreach ($range as $i) {
    echo sprintf("Image: %d %s", $i+1, PHP_EOL);
    createImage($i+1);
}

function createImage($index): array
{
    $time_start = microtime(true);

    Bag::createImage();

    $total_time = number_format(microtime(true) - $time_start, 2);
    echo sprintf("Image %d total execution time in seconds: %f.%s", $index, $total_time, PHP_EOL);
    return [$index => $total_time];
}

$scritp_total_time = number_format(microtime(true) - $script_time_start, 2);
echo sprintf("Script total execution time in seconds: %f.%s", $scritp_total_time, PHP_EOL);
echo sprintf("Script memory usage: %s.%s", Bag::memoryUsageFormatted(), PHP_EOL);
