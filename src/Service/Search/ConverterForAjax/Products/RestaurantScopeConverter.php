<?php

namespace App\Service\Search\ConverterForAjax\Products;

use App\Service\Search\ConverterForAjax\ConverterForAjaxInterface;

use App\Entity\RestaurantTable;

class RestaurantScopeConverter implements ConverterForAjaxInterface
{
    public function convert(array $arrayToConvert): array
    {
        // TODO: Implement this method.
    }

    private function getRequiredDataForGivenObject(RestaurantTable $restaurantTable): array
    {
        $arraToBeReturned = [];
        // TODO: Construct this array to send to client
    }
}