<?php

namespace App\Service\Restaurants\Factory\HandlerFactory;

use App\Service\Restaurants\Factory\Products\RestaurantsHandlerInterface;

interface HandlerFactoryInterface
{
    public function create(array $queryParams): RestaurantsHandlerInterface;
}