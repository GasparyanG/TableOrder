<?php

namespace App\Service\Reservation\ReservationSupplier;

use App\Entity\Reservation;
use App\Entity\User;

interface ReservationSupplierInterface
{
    public function getNextReservation(string $reservationTime,  string $reservationDate, $table): ?Reservation;

    public function getPreviousReservation(string $reservationTime,  string $reservationDate, $table): ?Reservation;

    public function getUpcomingReservations(User $user, bool $forDashboard = true): array;

    public function getPassedReservations(User $user, bool $forDashboard = true): array;

    public function getAllReservations(User $user): array;

    public function getAmountOfReservations(User $user): int;
}