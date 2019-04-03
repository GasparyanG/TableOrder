<?php

namespace App\Service\DatabaseHighLvlManipulation\Insertion\Reservation\Products;

use App\Service\ConfigurationFetcher\Keys\KeysFetcherInterface;
use App\Service\DatabaseHighLvlManipulation\Insertion\Reservation\ReservationInsertionInterface;
use App\Service\User\UserSupporterInterface;
use Psr\Log\LoggerInterface;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Component\HttpFoundation\Request;

// entity
use App\Entity\Reservation;
use App\Entity\Restaurant;
use App\Entity\RestaurantTable;

class ReservationInserter implements ReservationInsertionInterface
{
    private $request;
    private $keysFetcher;
    private $userSupporter;

    //db
    private $em;
    private $restaurantRepo;
    private $restaurantTableRepo;

    // DEV
    private $logger;

    public function __construct(KeysFetcherInterface $keysFetcher,
                                UserSupporterInterface $userSupporter,
                                RegistryInterface $registry,
                                LoggerInterface $logger)
    {
        $this->request = Request::createFromGlobals();
        $this->keysFetcher = $keysFetcher;
        $this->userSupporter = $userSupporter;

        // db
        $this->em = $registry->getEntityManager();
        $this->restaurantRepo = $this->em->getRepository(Restaurant::class);
        $this->restaurantTableRepo = $this->em->getRepository(RestaurantTable::class);

        // DEV
        $this->logger = $logger;
    }

    public function getPopulatedObject(string $restaurantName, int $restaurantId): Reservation
    {
        $queryParams = $this->request->query->all();
        $reservation = new Reservation();

        // user
        $user = $this->userSupporter->getUser();
        $reservation->setUser($user);

        // restaurant
        $restaurant = $this->restaurantRepo->find($restaurantId);
        $reservation->setRestauran($restaurant);

        // reservation time
        $reservationTimeFromQuery = $queryParams[$this->keysFetcher->getReservationTime()];
        $reservationTime = new \DateTime($reservationTimeFromQuery);
        $reservation->setReservationTime($reservationTime);

        // reservation date
        $reservationDateFromQuery = $queryParams[$this->keysFetcher->getReservationDate()];
        $reservationDate = new \DateTime($reservationDateFromQuery);
        $reservation->setReservationDate($reservationDate);

        // restaurant table
        $tableId = $queryParams[$this->keysFetcher->getTableId()];
        $table = $this->restaurantTableRepo->find($tableId);
        $reservation->setTable($table);

        // table number
        $tableNumber = $table->getTableNumber();
        $reservation->setTableNumber($tableNumber);

        // amount of time
        $requestParams = $this->request->request->all();
        $amountOfTime = $requestParams[$this->keysFetcher->getAmountOfTime()];

        // converting to integer
        $amountOfTime = (int) $amountOfTime;

        $reservation->setAmountOfTime($amountOfTime);

        return $reservation;
    }

    public function insertIntoDatabase(Reservation $reservation): void
    {
        $this->em->persist($reservation);
        $this->em->flush();
    }
}