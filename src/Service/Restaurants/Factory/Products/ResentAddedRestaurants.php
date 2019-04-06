<?php

namespace App\Service\Restaurants\Factory\Products;

class ResentAddedRestaurants extends RestaurantsHandlerAncestor implements RestaurantsHandlerInterface
{
    public function isUsed(array $queryParams): bool
    {
        return $this->getMyFilter() === $this->getFilterFromQueryParams($queryParams);
    }

    public function getRestaurants(array $queryParams): array
    {
        // this is not info holder restaurant it is just helping to filter required restaurant: restaurant set!
        $resentAddedRestaurants = $this->getResentAddedRestaurants($queryParams);

        // this array of restaurants, which holds only Restaurant table's info.
        $actualRestaurants = $this->getActualRestaurants($resentAddedRestaurants);

        return $this->prepareRestaurantDetails($actualRestaurants);
    }

    protected function getMyFilter(): string
    {
        $myFilter = $this->restaurantsConfigFetcher->getResentAdded();
        return $myFilter;
    }

    private function getResentAddedRestaurants(array $queryParams): array
    {
        $offsetKey = $this->restaurantsConfigFetcher->getOffset();
        $offset = $queryParams[$offsetKey];
        $limit = $this->restaurantsConfigFetcher->getDefaultLimit();

        $restaurantDetailsArray = $this->resDetRepo->findResentAdded($offset, $limit);

        return $restaurantDetailsArray;
    }
}