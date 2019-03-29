<?php

namespace App\Service\Reservation\ReservationSupplier\User;


use App\Entity\User;

interface UserReservationSupplierInterface
{
    public function getUpcomingReservations(User $user, bool $forDashboard = true): array;

    public function getPassedReservations(User $user, bool $forDashboard = true): array;

    public function getAllReservations(User $user): array;

    public function getAmountOfReservations(User $user): int;
}