<?php

namespace App\Service\Reservation\Bridge;

use App\Entity\Reservation;

interface ReservationBridgeInterface
{
    public function restaurantExists(string $restaurantName, int $restaurantId): bool;

    /**
     *  query param fetcher will do rest, which means that bridge need to have queryParamFetcher
     *  
     * @return int|null null will be returned if table does not exists or query string don't have
     *      it specified
     */
    public function getRestaurantTableId(array $queryParam): ?int;
    
    public function tableExists(int $tableId, int $restaurantId): bool;

    public function replace(array $queryParams): void;

    public function prepareReservationWithoutAmountOfTime(): ?Reservation;
}