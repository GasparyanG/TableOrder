<?php

namespace App\Service\Reservation\Preparing;

use App\Entity\Reservation;

interface ReservationPreparingInterface
{
    public function prepareReservation(): ?Reservation;
    public function prepareReservationWithoutAmountOfTime(): ?Reservation;
}