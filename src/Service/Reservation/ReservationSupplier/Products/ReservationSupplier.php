<?php

namespace App\Service\Reservation\ReservationSupplier\Products;

use App\Service\Reservation\ReservationSupplier\ReservationSupplierInterface;
use Symfony\Bridge\Doctrine\RegistryInterface;
// entities
use App\Entity\Reservation;

class ReservationSupplier implements ReservationSupplierInterface
{
    public function __construct(RegistryInterface $registry)
    {
        $this->em = $registry->getManager();
        $this->reservationRepo = $this->em->getRepository(Reservation::class);
    }

    public function getNextReservation(string $reservationTime,  string $reservationDate, $table): ?Reservation
    {
        $nextReservation = $this->reservationRepo->findNextReservation($reservationTime, $reservationDate, $table);
        if ($nextReservation) {
            return $nextReservation[0];
        }

        return null;
    }

    public function getPreviousReservation(string $reservationTime,  string $reservationDate, $table): ?Reservation
    {
        $nextReservation = $this->reservationRepo->findPreviouseReservation($reservationTime, $reservationDate, $table);
        if ($nextReservation) {
            return $nextReservation[0];
        }

        return null;
    }
}