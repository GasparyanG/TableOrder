<?php

namespace App\Service\ConfigurationFetcher\Errors\Products;

use App\Service\ConfigurationFetcher\Errors\ErrorFetcherInterface;
use Symfony\Component\Yaml\Yaml;

class ErrorFetcher implements ErrorFetcherInterface
{
    private $errorConf;

    public function __construct()
    {
        $this->errorConf = Yaml::parseFile(__DIR__ . "/../../../../../config/packages/client_side_guru/default_errors.yaml");
    }

    public function getAmountOfTIme(): string
    {
        return $this->errorConf["reservation"]["amountOfTime"];
    }
}