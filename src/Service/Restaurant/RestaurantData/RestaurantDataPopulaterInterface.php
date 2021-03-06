<?php

namespace App\Service\Restaurant\RestaurantData;

interface RestaurantDataPopulaterInterface
{
    public function populateRestaurantWithData(array $restaurants): array;

    public function populateRestaurantsWithData(array $restaurants): array;
}