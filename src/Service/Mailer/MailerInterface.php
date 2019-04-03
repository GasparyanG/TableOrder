<?php

namespace App\Service\Mailer;

use App\Entity\Reservation;

interface MailerInterface
{
    public function sendVerificationCode(string $email): void;

    public function sendReservationDetailsToUser(Reservation $reservation): void;
}