<?php

namespace App\Service\Reservation\ReservationSupplier\Products;

use App\Service\Reservation\ReservationSupplier\ReservationSupplierInterface;
use App\Service\Reservation\ReservationSupplier\User\UserReservationSupplierInterface;
use Symfony\Bridge\Doctrine\RegistryInterface;

// entities
use App\Entity\Reservation;
use App\Entity\User;

class ReservationSupplier implements ReservationSupplierInterface
{
    private $em;
    private $reservationRepo;
    private $userReservationSupplier;

    public function __construct(RegistryInterface $registry, UserReservationSupplierInterface $userReservationSupplier)
    {
        $this->userReservationSupplier = $userReservationSupplier;

        // db
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

    public function getUpcomingReservations(User $user, bool $forDashboard = true): array
    {
        return $this->userReservationSupplier->getUpcomingReservations($user, $forDashboard);
    }

    public function getPassedReservations(User $user, bool $forDashboard = true): array
    {
        return $this->userReservationSupplier->getPassedReservations($user, $forDashboard);
    }

    public function getAllReservations(User $user): array
    {
        // TODO: imp getAllReservations() method
    }

    public function getAmountOfReservations(User $user): int
    {
        return $this->userReservationSupplier->getAmountOfReservations($user);
    }
}