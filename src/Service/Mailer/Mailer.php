<?php

namespace App\Service\Mailer;

use App\Service\Mailer\Authentication\Verification\VerificationMailerInterface;

use App\Entity\Reservation;
use App\Service\Mailer\Reservation\ReservationMailerInterface;

class Mailer implements MailerInterface
{
    private $verificationMailer;
    private $reservationMailer;

    public function __construct(VerificationMailerInterface $verificationMailer, ReservationMailerInterface $reservationMailer)
    {
        $this->verificationMailer = $verificationMailer;
        $this->reservationMailer = $reservationMailer;
    }

    public function sendVerificationCode(string $email): void
    {
        $this->verificationMailer->sendVerificationCode($email);
    }

    public function sendReservationDetailsToUser(Reservation $reservation): void
    {
        $this->reservationMailer->sendReservationDetailsToUser($reservation);
    }
}