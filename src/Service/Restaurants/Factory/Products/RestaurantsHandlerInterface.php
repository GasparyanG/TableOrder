<?php

namespace App\Service\Restaurants\Factory\Products;

interface RestaurantsHandlerInterface
{
    public function isUsed(array $queryParams): bool;

    public function getRestaurants(array $queryParams): array;
}