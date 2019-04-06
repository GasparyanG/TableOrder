<?php

namespace App\Service\Reservation\ReservationSupplier\User\Products;

use App\Service\Augmention\TimeAndDate\TimeAndDateSupplierInterface;
use App\Service\ConfigurationFetcher\Database\DatabaseFetcherInterface;
use App\Service\Reservation\ReservationSupplier\User\UserReservationSupplierInterface;

// entity
use App\Entity\User;
use App\Entity\Reservation;
use Symfony\Bridge\Doctrine\RegistryInterface;

// DEV
use Psr\Log\LoggerInterface;

class UserReservationSupplier implements UserReservationSupplierInterface
{
    private $databaseFetcher;
    private $em;
    private $reservationRepo;
    private $timeAndDateSupplier;
    private $logger;

    public function __construct(DatabaseFetcherInterface $databaseFetcher, RegistryInterface $registry, TimeAndDateSupplierInterface $timeAndDateSupplier, LoggerInterface $logger)
    {
        $this->databaseFetcher = $databaseFetcher;
        $this->timeAndDateSupplier = $timeAndDateSupplier;

        // db
        $this->em = $registry->getEntityManager();
        $this->reservationRepo = $this->em->getRepository(Reservation::class);

        // dev
        $this->logger = $logger;
    }

    public function getUpcomingReservations(User $user, bool $forDashboard = true): array
    {
        $amountToReturn = null;

        if ($forDashboard) {
            $amountToReturn = $this->databaseFetcher->getReservationUpcomingLimit();
        }

        else {
            $amountToReturn = $this->databaseFetcher->getReservationUpcomingMax();
        }

        $currentTime = $this->timeAndDateSupplier->getCurrentTime();
        $currentDate = $this->timeAndDateSupplier->getCurrentDate();

        return $this->reservationRepo->findUpcomingReservations($user, $amountToReturn, $currentTime, $currentDate);
    }

    public function getPassedReservations(User $user, bool $forDashboard = true): array
    {
        $amountToReturn = null;

        if ($forDashboard) {
            $amountToReturn = $this->databaseFetcher->getReservationUpcomingLimit();
        }

        else {
            $amountToReturn = $this->databaseFetcher->getReservationUpcomingMax();
        }

        $currentTime = $this->timeAndDateSupplier->getCurrentTime();
        $currentDate = $this->timeAndDateSupplier->getCurrentDate();

        return $this->reservationRepo->findPassedReservations($user, $amountToReturn, $currentTime, $currentDate);
    }

    public function getAllReservations(User $user): array
    {
        // TODO: implement getAllReservations() method
    }

    public function getAmountOfReservations(User $user): int
    {
        $amountOfReservations = $this->reservationRepo->findAmountOfReservations($user);

        return $amountOfReservations;
    }

    public function getRestaurantPassedReservations(int $restaurantId, User $user): array
    {
        $currentTime = $this->timeAndDateSupplier->getCurrentTime();
        $currentDate = $this->timeAndDateSupplier->getCurrentDate();

        return $this->reservationRepo->findRestaurantPassedReservations($restaurantId, $user, $currentTime, $currentDate);
    }
}