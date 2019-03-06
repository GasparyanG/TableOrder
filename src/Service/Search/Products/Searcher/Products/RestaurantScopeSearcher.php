<?php

namespace App\Service\Search\Products\Searcher\Products;

use App\Service\Search\Products\Searcher\Common\Searcher;
use App\Service\Search\Products\Searcher\SearcherInterface;

class RestaurantScopeSearcher extends Searcher implements SearcherInterface
{
    public function getNotReservedTables(array $queryParams): ?array
    {
        // getRestaurants
        $restaurantId = $this->fetcher->getRestaurantId($queryParams);
        $restaurantName = $this->fetcher->getRestaurantName($queryParams);
        $restaurants = $this->getRestaurant($restaurantId, $restaurantName);

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
            // this will help to notify about tables availability!
            return [];
        }

        return $notReservedTables;
    }
}