<?php

namespace App\Service\Mailer\Reservation;

use App\Entity\Reservation;

interface ReservationMailerInterface
{
    public function sendReservationDetailsToUser(Reservation $reservation): void;
}