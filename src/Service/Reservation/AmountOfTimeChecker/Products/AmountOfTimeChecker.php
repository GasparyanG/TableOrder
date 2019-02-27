<?php

namespace App\Service\Reservation\AmountOfTimeChecker\Products;

use App\Service\Reservation\AmountOfTimeChecker\AmountOfTimeCheckerInterface;
use App\Entity\Reservation;
use Symfony\Bridge\Doctrine\RegistryInterface;

class AmountOfTimeChecker implements AmountOfTimeCheckerInterface
{
    public function __construct(RegistryInterface $doctrine)
    {
        $this->doctrine = $doctrine;
        $em = $this->doctrine->getManager();
        $this->reservationRepo = $em->getRepository(Reservation::class);
    }

    public function checkAmountOfTime(Reservation $reservation): bool
    {
        $nextReservation = $this->reservationRepo->findNextReservation($reservation->getReservationTime()->format("H:i:s"), $reservation->getReservationDate()->format("Y-m-d"), $reservation->getTable());

        if (!$nextReservation) {
            return true;
        }

        $diffInMinutes = $this->subtraction($reservation, $nextReservation);
        if ($diffInMinutes - $reservation->getAmountOfTime() >= 0) {
            return true;
        }

        return false;
    }

    private function subtraction($reservation, $nextReservation): int
    {
        $reservationTime = $reservation->getReservationTime()->format("H:i:s");
        $reservationDate = $reservation->getReservationDate()->format("Y-m-d");
        $reservationTimestamp = strtotime($reservationDate . " " . $reservationTime);

        $nextReservationTime = $nextReservation->getReservationTime()->format("H:i:s");
        $nextReservationDate = $nextReservation->getReservationTime()->format("Y-m-d");
        $nextReservationTimestamp = strtotime($nextReservationDate . " " . $nextReservationTime);

        $diffInSec = $nextReservationTimestamp - $reservationTimestamp;
        $diffInMinutes = $diffInSec/60;

        return $diffInMinutes;
    }

    public function getValidAmountOfTime(Reservation $reservation): int
    {
        $nextReservation = $this->reservationRepo->findNextReservation($reservation->getReservationTime(), $reservation->getReservationDate(), $reservation->getTable());
        
        return $this->subtraction($reservation, $nextReservation);
    }
}