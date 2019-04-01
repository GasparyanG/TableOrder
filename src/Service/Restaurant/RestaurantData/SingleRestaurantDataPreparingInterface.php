<?php

namespace App\Service\Restaurant\RestaurantData;

use App\Entity\Restaurant;

interface SingleRestaurantDataPreparingInterface
{
    public function populateRestaurant(Restaurant $restaurant): array;
}