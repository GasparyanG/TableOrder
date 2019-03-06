<?php

namespace App\Service\Search\Products\Searcher\Common;

use Symfony\Bridge\Doctrine\RegistryInterface;
use App\Entity\Restaurant;
use App\Entity\RestaurantTable;
use App\Entity\Reservation;
use App\Service\ClientSideGuru\QueryString\Search\QueryStringFetcherInterface;

use Psr\Log\LoggerInterface;

class Searcher
{
    protected $doctrine;
    // entity manager
    protected $em;
    protected $restaurantRepo;
    protected $restaurantTableRepo;
    protected $fetcher;

    public function __construct(RegistryInterface $doctrine, QueryStringFetcherInterface $fetcher, LoggerInterface $logger)
    {
        // services
        $this->doctrine = $doctrine;
        $this->fetcher = $fetcher;
        $this->logger = $logger;

        // database repositories
        $this->em = $this->doctrine->getManager();
        $this->restaurantRepo = $this->em->getRepository(Restaurant::class);
        $this->restaurantTableRepo = $this->em->getRepository(RestaurantTable::class);
        $this->reservationRepo = $this->em->getRepository(Reservation::class);
    }

    protected function getRestaurants(string $location, string $restaurantName = null): array
    {
        if ($restaurantName) {
            $restaurants = $this->restaurantRepo->findBy(['location' => $location, 'name' => $restaurantName]);
        }

        else {
            $restaurants = $this->restaurantRepo->findBy(['location' => $location]);
        }

        return $restaurants;
    }

    protected function getRestaurantsTables(array $restaurants, int $personAmount): array
    {
        $tables = $this->restaurantTableRepo->findRestaurantTables($restaurants, $personAmount);

        return $tables;
    }

    protected function getReservedTables(array $allTables, string $reservationTime, string $reservationDate): array
    {
        $reservations = $this->reservationRepo->findReservedTables($allTables, $reservationTime, $reservationDate);

        return $reservations;
    }

    protected function fetcheNotReservedTables(array $allTables, array $reservations): array
    {
        /**
         * 1) get reservations' reservation's table's id
         * 2) remove reservation's id
         * 3) return not reserved table's id
         */

        $notReservedTables = [];

        $tablesIds = $this->getReservationsTablesIds($reservations);

        foreach ($allTables as $table) {
            if (in_array($table->getId(), $tablesIds)) {
                continue;
            }

            $notReservedTables[] = $table;
        }

        return $notReservedTables;
    }

    private function getReservationsTablesIds(array $reservations): array
    {
        $tablesIds = [];
        
        foreach ($reservations as $reservation) {
            $tablesIds[] = $reservation->getTable()->getId();
        }

        return $tablesIds;
    }

    public function getRestaurant(int $restaurantId, string $restaurantName): array
    {
        return $this->restaurantRepo->findBy(["id" => $restaurantId, "name" => $restaurantName]);
    }
}