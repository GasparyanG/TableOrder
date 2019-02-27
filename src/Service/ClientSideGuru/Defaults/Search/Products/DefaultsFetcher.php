<?php

namespace App\Service\ClientSideGuru\Defaults\Search\Products;

use App\Service\ClientSideGuru\Defaults\Search\DefaultsFetcherInterface;
use Symfony\Component\Yaml\Yaml;

class DefaultsFetcher implements DefaultsFetcherInterface
{
    private $defaultsConf;

    public function __construct()
    {
        $this->defaultsConf = Yaml::parseFile(__DIR__ . "/../../../../../../config/packages/client_side_guru/defaults.yaml");
    }

    public function getLocation(): string
    {
        return $this->defaultsConf['search']['location'];
    }

    public function getPersonAmount(): int
    {
        return $this->defaultsConf['search']['personAmount'];
    }
}