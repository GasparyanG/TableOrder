<?php

namespace App\Service\ConfigurationFetcher\Specific\Products;

use App\Service\ConfigurationFetcher\Specific\SpecificConfigFetcherInterface;
use Symfony\Component\Yaml\Yaml;

class SpecificConfigFetcher implements SpecificConfigFetcherInterface
{
    private $specificConfig;

    public function __construct()
    {
        $this->specificConfig = Yaml::parseFile(__DIR__ . "/../../../../../config/specific/mailer_config.yaml");
    }

    public function getUsername(): string
    {
        return $this->specificConfig["gmail"]["username"];
    }

    public function getPassword(): string
    {
        return $this->specificConfig["gmail"]["password"];
    }
}