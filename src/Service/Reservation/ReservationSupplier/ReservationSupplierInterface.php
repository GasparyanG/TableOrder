<?php

namespace App\Service\Reservation\ReservationSupplier;

use App\Entity\Reservation;

interface ReservationSupplierInterface
{
    public function getNextReservation(string $reservationTime,  string $reservationDate, $table): ?Reservation;

    public function getPreviousReservation(string $reservationTime,  string $reservationDate, $table): ?Reservation;
}