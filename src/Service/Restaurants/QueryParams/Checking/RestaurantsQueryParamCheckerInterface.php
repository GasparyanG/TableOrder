<?php

namespace App\Service\Restaurants\QueryParams\Checking;

interface RestaurantsQueryParamCheckerInterface
{
    public function check(): bool;
}