<?php

namespace App\Service\Augmention\TimeAndDate;

interface TimeAndDateSupplierInterface
{
    public function getCurrentTime(): string;

    public function getCurrentDate(): string;
}