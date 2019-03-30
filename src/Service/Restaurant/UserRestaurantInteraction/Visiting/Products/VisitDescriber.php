<?php

namespace App\Service\Restaurant\UserRestaurantInteraction\Visiting\Products;

use App\Service\Reservation\ReservationSupplier\ReservationSupplierInterface;
use App\Service\Restaurant\UserRestaurantInteraction\Visiting\VisitDescriberInterface;
use App\Service\User\UserSupporterInterface;

//entity
use App\Entity\User;

class VisitDescriber implements VisitDescriberInterface
{
    private $userSupporter;
    private $reservationSupplier;

    public function __construct(UserSupporterInterface $userSupporter,
                                ReservationSupplierInterface $reservationSupplier)
    {
        $this->userSupporter = $userSupporter;
        $this->reservationSupplier = $reservationSupplier;
    }

    public function visitedByUser(int $restaurantId): bool
    {
        $user = $this->userSupporter->getUser();

        // not authenticated user
        if (!$user) {
            return false;
        }

        // authenticated user
        if ($this->isVisited($restaurantId, $user)) {
            return true;
        }

        return false;
    }

    private function isVisited(int $restaurantId, User $user): bool
    {
        $boolToReturn = false;
        // to be considered as visitor below mentioned need to be true

        // user has reservation before now
        if ($this->reservationSupplier->getPassedReservations($user)) {
            $boolToReturn = true;
        }

        return $boolToReturn;
    }
}