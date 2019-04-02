<?php

namespace App\Service\Reservation\Validation;

interface ReservationValidationInterface
{
    public function getRequestIsValid(string $restaurantName, int $restaurantId): bool;
}