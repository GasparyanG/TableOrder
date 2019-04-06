<?php

namespace App\Service\ConfigurationFetcher\Specific\Restaurants;

interface RestaurantsConfigFetcherInterface
{
    public function getFilter(): string;

    public function getOffset(): string;

    public function getResentAdded(): string;

    public function getMostRated(): string;

    public function getFilters(): array;

    public function getDefaultFilter(): string;

    public function getDefaultOffset(): int;

    public function getDefaultLimit(): int;
}