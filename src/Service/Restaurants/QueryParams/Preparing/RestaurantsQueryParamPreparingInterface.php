<?php

namespace App\Service\Restaurants\QueryParams\Preparing;

interface RestaurantsQueryParamPreparingInterface
{
    public function getDefaultQueryParams(): array;

    public function getSettledQueryParams(): array;
}