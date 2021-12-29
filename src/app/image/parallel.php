<?php

require __DIR__ . '/../../vendor/autoload.php';
require __DIR__ . '/../Bag.php';

use Amp\Parallel\Worker\DefaultPool;
use function Amp\ParallelFunctions\parallelMap;
use function Amp\Promise\wait;

Bag::debug();

$script_time_start = microtime(true);

$promises = parallelMap(range(1, 49), function ($index) {
    echo sprintf("Image: %d.%s", $index, PHP_EOL);

    $time_start = microtime(true);

    $draw = new \ImagickDraw();
    $draw->setFillColor('#a4610f');
    for ($x = 0; $x < 10000; $x++) {
        $draw->point(rand(0, 500), rand(0, 500));
    }

    $imagick = new \Imagick();
    $imagick->newImage(4000, 4000, new \ImagickPixel('red'));
    $imagick->setImageFormat('png');
    $imagick->drawImage($draw);
    $output = $imagick->getImageBlob();

    $total_time = number_format(microtime(true) - $time_start, 2);
    echo sprintf("Image %d total execution time in seconds: %f.%s", $index, $total_time, PHP_EOL);
    return [$index => $total_time];
});

wait($promises);

$scritp_total_time = number_format(microtime(true) - $script_time_start, 2);
echo sprintf("Script total execution time in seconds: %f.%s", $scritp_total_time, PHP_EOL);
echo sprintf("Script memory usage: %s.%s", Bag::memoryUsageFormatted(), PHP_EOL);
