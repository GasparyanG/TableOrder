<?php

namespace App\Service\Reservation\AmountOfTimeChecker;

use App\Entity\Reservation;

interface AmountOfTimeCheckerInterface
{
    public function checkAmountOfTime(Reservation $reservation): bool;

    public function getValidAmountOfTime(Reservation $reservation): int;
}