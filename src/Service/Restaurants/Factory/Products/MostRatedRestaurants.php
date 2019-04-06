<?php

namespace App\Service\Restaurants\Factory\Products;

class MostRatedRestaurants extends RestaurantsHandlerAncestor implements RestaurantsHandlerInterface
{
    public function isUsed(array $queryParams): bool
    {
        return $this->getMyFilter() === $this->getFilterFromQueryParams($queryParams);
    }

    public function getRestaurants(array $queryParams): array
    {
        $mostRatedRestaurants = $this->getMostRatedRestaurants($queryParams);
        $actualRestaurants = $this->getActualRestaurants($mostRatedRestaurants);

        return $this->prepareRestaurantDetails($actualRestaurants);
    }

    protected function getMyFilter(): string
    {
        $myFilter = $this->restaurantsConfigFetcher->getMostRated();
        return $myFilter;
    }

    private function getMostRatedRestaurants(array $queryParams): array
    {
        $offsetKey = $this->restaurantsConfigFetcher->getOffset();
        $offset = $queryParams[$offsetKey];
        $limit = $this->restaurantsConfigFetcher->getDefaultLimit();

        $restaurantDetailsArray = $this->resDetRepo->findMostRatedRestaurants($offset, $limit);

        return $restaurantDetailsArray;
    }
}