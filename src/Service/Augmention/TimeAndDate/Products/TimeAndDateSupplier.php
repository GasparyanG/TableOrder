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

    public function getTime(): string
    {
        return time();
    }

    public function fromFuture(string $timeAndDate): bool
    {
        $currentTimeAndDate = $this->getCurrentDate() . " " . $this->getCurrentTime();

        if ($currentTimeAndDate > $timeAndDate) {
            return false;
        }

        return true;
    }

}