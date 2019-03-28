<?php

namespace App\Service\Augmention\TimeAndDate\Products;

use App\Service\Augmention\TimeAndDate\TimeAndDateSupplierInterface;

class TimeAndDateSupplier implements TimeAndDateSupplierInterface
{
    public function getCurrentTime(): string
    {
        $time = time();
        $currentTime = date("H:i:s", $time);

        return $currentTime;
    }

    public function getCurrentDate(): string
    {
        $time = time();
        $currentTime = date("Y-m-d", $time);

        return $currentTime;
    }
}