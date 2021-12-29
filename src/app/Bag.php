<?php

class Bag
{
    public static function debug(): void
    {
        ini_set('display_errors', '1');
        ini_set('display_startup_errors', '1');
        error_reporting(E_ALL);
    }

    public static function memoryUsageFormatted(): string
    {
        $memory = memory_get_usage(true);
        if ($memory < 1024) {
            return $memory .= ' b';
        }
    
        if ($memory < 1048576) {
            return round($memory/1024,2) . ' Kb';
        }
    
        return round($memory/1048576,2) . ' Mb';
    }

    public static function createImage(): string
    {
        $draw = new \ImagickDraw();
        $draw->setFillColor('#a4610f');
        for ($x = 0; $x < 10000; $x++) {
            $draw->point(rand(0, 500), rand(0, 500));
        }
    
        $imagick = new \Imagick();
        $imagick->newImage(4000, 4000, new \ImagickPixel('red'));
        $imagick->setImageFormat("png");
        $imagick->drawImage($draw);
    
        return $imagick->getImageBlob();
    }
}
