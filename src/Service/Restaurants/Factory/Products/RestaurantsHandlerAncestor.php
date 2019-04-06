<?php

namespace App\Service\Restaurants\Factory\Products;

use App\Entity\Restaurant;
use App\Service\ConfigurationFetcher\Specific\Restaurants\RestaurantsConfigFetcherInterface;
use App\Service\Restaurant\RestaurantData\RestaurantDataPopulaterInterface;
use Symfony\Bridge\Doctrine\RegistryInterface;

// db
use App\Entity\RestaurantDetails;

class RestaurantsHandlerAncestor
{
    protected $restaurantsConfigFetcher;
    protected $restaurantDataPopulater;

    // db
    protected $em;
    protected $resDetRepo;
    protected $restaurantRepo;

    public function __construct(RestaurantsConfigFetcherInterface $restaurantsConfigFetcher,
                                RegistryInterface $registry,
                                RestaurantDataPopulaterInterface $restaurantDataPopulater)
    {
        $this->restaurantsConfigFetcher = $restaurantsConfigFetcher;
        $this->restaurantDataPopulater = $restaurantDataPopulater;

        // db
        $this->em = $registry->getEntityManager();
        $this->resDetRepo = $this->em->getRepository(RestaurantDetails::class);
        $this->restaurantRepo = $this->em->getRepository(Restaurant::class);
    }

    protected function getFilterFromQueryParams(array $queryParams): string
    {
        $filterKey = $this->restaurantsConfigFetcher->getFilter();

        return $queryParams[$filterKey];
    }

    protected function getMyFilter(): string
    {
        // will be implemented in successors
    }

    protected function prepareRestaurantDetails(array $restaurants): array
    {
        return $this->restaurantDataPopulater->populateRestaurantsWithData($restaurants);
    }

    protected function getActualRestaurants(array $resentAddedRestaurants): array
    {
        $actualRestaurants = [];
        foreach($resentAddedRestaurants as $resentAddedRestaurant) {
            $currentRestaurantName = $resentAddedRestaurant->getName();
            $actualRestaurants[] = $this->restaurantRepo->findOneBy(["name" => $currentRestaurantName]);
        }

        return $actualRestaurants;
    }
}