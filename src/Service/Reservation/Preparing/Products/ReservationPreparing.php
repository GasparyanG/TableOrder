<?php

namespace App\Service\Reservation\Preparing\Products;

use App\Service\Reservation\Preparing\ReservationPreparingInterface;
use App\Entity\Reservation;
use Symfony\Component\HttpFoundation\Request;
use App\Service\ClientSideGuru\QueryString\Reservation\Products\QueryParamFetcher;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use App\Service\User\UserSupporterInterface;
use App\Entity\RestaurantTable;
use Symfony\Bridge\Doctrine\RegistryInterface;

class ReservationPreparing implements ReservationPreparingInterface
{
    public function __construct(QueryParamFetcher $queryParamFetcher, SessionInterface $session, UserSupporterInterface $userSupporter, RegistryInterface $doctrine)
    {
        $this->request = Request::createFromGlobals();
        $this->userSupporter = $userSupporter;
        $this->queryParamFetcher = $queryParamFetcher;
        $this->session = $session;
        $this->reservation = new Reservation();

        $em = $doctrine->getManager();
        $this->restaurantTableRepo = $em->getRepository(RestaurantTable::class);
    }

    public function prepareReservation(): ?Reservation
    {
        $reservationRequiredData = $this->session->all();

        // reservation time
        $reservationTime = $this->queryParamFetcher->getReservationTime($reservationRequiredData);
        $this->reservation->setReservationTime(new \DateTime($reservationTime));
        // reservation date
        $reservationDate = $this->queryParamFetcher->getReservationDate($reservationRequiredData);
        $this->reservation->setReservationDate(new \DateTime($reservationDate));
        // amount of time
        $postedData = $this->request->request->all();
        $amountOfTime = $this->queryParamFetcher->getAmountOfTime($postedData);
        $this->reservation->setAmountOfTime($amountOfTime);
        // table id
        $tableId = $this->queryParamFetcher->getTableId($reservationRequiredData);
        $table = $this->restaurantTableRepo->find($tableId);
        $this->reservation->setTable($table);
        // table number
        $this->reservation->setTableNumber($table->getTableNumber());
        //restaurant
        $this->reservation->setRestauran($table->getRestaurant());
        // user
        $user = $this->userSupporter->getUser();
        $this->reservation->setUser($user);

        return $this->reservation;
    }
}