<?php

namespace App\Service\Search\Products\Searcher\Products;

use App\Service\Search\Products\Searcher\Common\Searcher;
use App\Service\Search\Products\Searcher\SearcherInterface;

class GlobalSearcher extends Searcher implements SearcherInterface
{
    public function getNotReservedTables(array $queryParams): ?array
    {
        // getRestaurants
        $location = $this->fetcher->getLocation($queryParams);
        // restaurant name (second argument) not specified, because restaurant does not known!
        $restaurants = $this->getRestaurants($location);

        if (count($restaurants) === 0) {
            return null;
        }

        /**
         * []- getTables : restaurantId ? [restaurantId] : [restaurant]                 false
         * []- getReservedTables: same ^^^ issue                                        false
         * []- remove reserved table id from all tables (retunred previousely) array
         * []- return [table]: table ? [table] : getTablsBasedOnTableId()
        */

        // all tables, which correspond to person amount and restaurants
        $personAmount = $this->fetcher->getPersonAmount($queryParams);

        // this array can't be null, because there is no restaurant without tables
        $allTables = $this->getRestaurantsTables($restaurants, $personAmount);

        // reserved tables
        $reservationTime = $this->fetcher->getReservationTime($queryParams);
        $reservationDate = $this->fetcher->getReservationDate($queryParams);
        $reservations = $this->getReservedTables($allTables, $reservationTime, $reservationDate);

        if (count($reservations) === 0) {
            // this tables are not reserved!
            return $allTables;
        }

        // is there not reserved table ?
        $notReservedTables = $this->fetcheNotReservedTables($allTables, $reservations);
        if (count($notReservedTables) === 0) {
            return null;
        }

        return $notReservedTables;
    }
}   