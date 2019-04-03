<?php

namespace App\Service\DatabaseHighLvlManipulation\Insertion\Reservation;

use App\Entity\Reservation;

interface ReservationInsertionInterface
{
    public function getPopulatedObject(string $restaurantName, int $restaurantId): Reservation;

    public function insertIntoDatabase(Reservation $reservation): void;
}