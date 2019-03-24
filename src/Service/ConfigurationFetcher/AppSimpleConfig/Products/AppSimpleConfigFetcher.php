<?php

namespace App\Service\ConfigurationFetcher\AppSimpleConfig\Products;

use App\Service\ConfigurationFetcher\AppSimpleConfig\AppSimpleConfigFetcherInterface;
use Symfony\Component\Yaml\Yaml;

class AppSimpleConfigFetcher implements AppSimpleConfigFetcherInterface
{
    private $authenticationConfig;

    public function __construct()
    {
        $this->authenticationConfig = Yaml::parseFile(__DIR__ . "/../../../../../config/app_simple_config/authentication_config.yaml");
    }

    public function getTriesAmount(): int
    {
        return $this->authenticationConfig["verification"]["amount_of_tries"];
    }
}