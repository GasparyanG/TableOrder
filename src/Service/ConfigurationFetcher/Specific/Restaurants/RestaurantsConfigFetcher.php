<?php

namespace App\Service\ConfigurationFetcher\Specific\Restaurants;

use Symfony\Component\Yaml\Yaml;

class RestaurantsConfigFetcher implements RestaurantsConfigFetcherInterface
{
    private $restaurantsConfig;

    public function __construct()
    {
        $this->restaurantsConfig = Yaml::parseFile(__DIR__ . "/../../../../../config/specific/restaurants.yaml");
    }

    public function getFilter(): string
    {
        return $this->restaurantsConfig["filter"]["filter"];
    }

    public function getOffset(): string
    {
        return $this->restaurantsConfig["filter"]["offset"];
    }

    public function getResentAdded(): string
    {
        return $this->restaurantsConfig["filter"]["values"]["resentAdded"];
    }

    public function getMostRated(): string
    {
        return $this->restaurantsConfig["filter"]["values"]["mostRated"];
    }

    public function getFilters(): array
    {
        $arrayOfFilters = [];

        // resent added
        $arrayOfFilters[] = $this->getResentAdded();
        $arrayOfFilters[] = $this->getMostRated();

        return $arrayOfFilters;
    }

    public function getDefaultFilter(): string
    {
        return $this->restaurantsConfig["defaults"]["filter"];
    }

    public function getDefaultOffset(): int
    {
        return $this->restaurantsConfig["defaults"]["offset"];
    }

    public function getDefaultLimit(): int
    {
        return $this->restaurantsConfig["defaults"]["limit"];
    }
}