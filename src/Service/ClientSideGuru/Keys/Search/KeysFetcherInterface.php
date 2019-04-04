<?php

namespace App\Service\ClientSideGuru\Keys\Search;

interface KeysFetcherInterface
{
    public function getLocation(): string;
    
    public function getPersonAmount(): string;

    public function getReservationTime(): string;

    public function getRestaurantName(): string;

    public function getRestaurantId(): string;
    
    public function getReservationDate(): string;

    public function getNotifications(): string;

    public function getAmountOfNotifications(): string;
}