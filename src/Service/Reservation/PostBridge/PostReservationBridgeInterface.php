<?php

namespace App\Service\Reservation\PostBridge;

use App\Entity\Reservation;

interface PostReservationBridgeInterface
{
    /**
     * Symfony validator component will return array of errors if
     * there is some and if no then null will be returned
     * 
     * @return null|array
     */
    public function checkReservation(Reservation $reservationRequiredData): ?array;

    public function prepareReservation(): ?Reservation;

    public function checkAmountOfTime(Reservation $reservation): bool;

    public function getValidAmountOfTime(Reservation $reservation): int;

    public function saveReservation(Reservation $reservation): void;
}