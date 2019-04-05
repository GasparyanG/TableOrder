<?php

namespace App\Service\ConfigurationFetcher\Keys\Products;

use App\Service\ConfigurationFetcher\Keys\KeysFetcherInterface;
use Symfony\Component\Yaml\Yaml;

class KeysFetcher implements KeysFetcherInterface
{
    private $keysConfig;

    public function __construct()
    {
        $this->keysConfig = Yaml::parseFile(__DIR__ . "/../../../../../config/packages/client_side_guru/keys.yaml");
    }

    public function getComment(): string
    {
        return $this->keysConfig["restaurant"]["comment"];
    }

    public function getRating(): string
    {
        return $this->keysConfig["restaurant"]["rating"];
    }

    public function getBookmark(): string
    {
        return $this->keysConfig["restaurant"]["bookmark"];
    }

    public function getRestaurant(): string
    {
        return $this->keysConfig["restaurant"]["restaurant"];
    }

    public function getPersonAmount(): string
    {
        return $this->keysConfig["table"]["personAmount"];
    }

    public function getTableId(): string
    {
        return $this->keysConfig["table"]["tableId"];
    }

    public function getReservationTime(): string
    {
        return $this->keysConfig["reservation"]["reservationTime"];
    }

    public function getReservationDate(): string
    {
        return $this->keysConfig["reservation"]["reservationDate"];
    }

    public function getAmountOfTime(): string
    {
        return $this->keysConfig["reservation"]["amountOfTime"];
    }

    public function getUsername(): string
    {
        return $this->keysConfig["auth"]["username"];
    }

    public function getPassword(): string
    {
        return $this->keysConfig["auth"]["password"];
    }
}