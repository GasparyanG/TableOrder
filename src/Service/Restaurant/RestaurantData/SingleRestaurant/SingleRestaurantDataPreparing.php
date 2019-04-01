<?php

namespace App\Service\Restaurant\RestaurantData\SingleRestaurant;

use App\Service\ConfigurationFetcher\Keys\KeysFetcherInterface;
use App\Service\Restaurant\RestaurantData\SingleRestaurantDataPreparingInterface;

// entity
use App\Entity\Restaurant;
use App\Service\Restaurant\RestaurantSupplierInterface;

class SingleRestaurantDataPreparing implements SingleRestaurantDataPreparingInterface
{
    protected $restaurantData;
    protected $restaurantSupplier;
    protected $keysFetcher;

    public function __construct(RestaurantSupplierInterface $restaurantSupplier, KeysFetcherInterface $keysFetcher)
    {
        $this->restaurantData = [];
        $this->restaurantSupplier = $restaurantSupplier;
        $this->keysFetcher = $keysFetcher;
    }

    public function populateRestaurant(Restaurant $restaurant): array
    {
        $this->addRating($restaurant);

        return $this->restaurantData;
    }

    protected function addRating(Restaurant $restaurant): void
    {
        $restaurantId = $restaurant->getId();

        $rating = $this->restaurantSupplier->getRestaurantReview($restaurantId);

        $this->restaurantData[$this->keysFetcher->getRating()] = $rating;
    }
}