<?php

namespace App\Service\ClientSideGuru\Keys\Search\Products;

use App\Service\ClientSideGuru\Keys\Search\KeysFetcherInterface;
use Symfony\Component\Yaml\Yaml;

class KeysFetcher implements KeysFetcherInterface
{
    public function __construct()
    {
        $this->keysConf = Yaml::parseFile(__DIR__ . "/../../../../../../config/packages/client_side_guru/query_string_keys.yaml");
    }

    public function getLocation(): string
    {
        return $this->keysConf['search']['location'];
    }

    public function getPersonAmount(): string
    {
        return $this->keysConf['search']['personAmount'];
    }

    public function getReservationTime(): string
    {
        return $this->keysConf['search']['reservationTime'];
    }

    public function getRestaurantName(): string
    {
        return $this->keysConf['search']['restaurantName'];
    }

    public function getRestaurantId(): string
    {
        return $this->keysConf['search']['restaurantId'];
    }
    
    public function getReservationDate(): string
    {
        return $this->keysConf['search']['reservationDate'];
    }

    public function getNotifications(): string
    {
        return $this->keysConf['notification']['notifications'];
    }

    public function getAmountOfNotifications(): string
    {
        return $this->keysConf['notification']['amountOfNotifications'];
    }
}