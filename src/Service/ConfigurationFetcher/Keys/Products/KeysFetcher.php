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
}