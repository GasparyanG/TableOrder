<?php

namespace App\Service\ConfigurationFetcher\Database\DatabaseNames;

use Symfony\Component\Yaml\Yaml;

class DatabaseNameFetcher implements DatabaseNameFetcherInterface
{
    private $databaseNameConf;

    public function __construct()
    {
        $this->databaseNameConf = Yaml::parseFile(__DIR__ . "/../../../../../config/packages/database/names.yaml");
    }

    public function getReservationTableName(): string
    {
        return $this->databaseNameConf["reservation"]["objName"];
    }
}