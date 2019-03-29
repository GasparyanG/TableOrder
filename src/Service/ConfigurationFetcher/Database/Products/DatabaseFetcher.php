<?php

namespace App\Service\ConfigurationFetcher\Database\Products;

use App\Service\ConfigurationFetcher\Database\DatabaseFetcherInterface;
use Symfony\Component\Yaml\Yaml;

class DatabaseFetcher implements DatabaseFetcherInterface
{
    private $databaseConstraintsConf;

    public function __construct()
    {
        $this->databaseConstraintsConf = Yaml::parseFile(__DIR__ . "/../../../../../config/packages/database/constraints.yaml");
    }

    public function getReservationUpcomingLimit(): int
    {
        return $this->databaseConstraintsConf["reservation"]["dashboard"]["upcoming"]["limit"];
    }

    public function getReservationPassedLimit(): int
    {
        return $this->databaseConstraintsConf["reservation"]["dashboard"]["passed"]["limit"];
    }

    public function getReservationUpcomingMax(): int
    {
        return $this->databaseConstraintsConf["reservation"]["dashboard"]["upcoming"]["max"];
    }

    public function getReservationPassedMax(): int
    {
        return $this->databaseConstraintsConf["reservation"]["dashboard"]["passed"]["max"];
    }
}