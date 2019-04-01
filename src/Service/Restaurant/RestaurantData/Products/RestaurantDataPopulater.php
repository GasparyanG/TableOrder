<?php

namespace App\Service\Restaurant\RestaurantData\Products;

use App\Service\Restaurant\RestaurantData\RestaurantDataPopulaterInterface;
use App\Service\Restaurant\RestaurantSupplierInterface;
use App\Entity\Restaurant;

class RestaurantDataPopulater implements RestaurantDataPopulaterInterface
{
    private $restaurantSupplier;
    private $restaurantsWithPopulatedData;

    public function __construct(RestaurantSupplierInterface $restaurantSupplier)
    {
        $this->restaurantSupplier = $restaurantSupplier;
        $this->restaurantsWithPopulatedData = [];
    }

    /**
     * template pattern
    */
    public function populateRestaurantWithData(array $restaurants): array
    {
        $this->prepaRerestaurantsWithPopulatedData($restaurants);
        $this->addRatings();

        return $this->restaurantsWithPopulatedData;
    }

    private function addRatings(): void
    {
        $changesArray = [];

        foreach($this->restaurantsWithPopulatedData as $restaurantArray){
            $restaurant = $restaurantArray["restaurant"];
            $restaurantId = $restaurant->getId();

            $restaurantArray["rating"] = $this->restaurantSupplier->getRestaurantReview($restaurantId);
            $changesArray[] = $restaurantArray;
        }

        $this->restaurantsWithPopulatedData = $changesArray;
    }

    private function prepaRerestaurantsWithPopulatedData(array $restaurants): void
    {
        foreach($restaurants as $restaurant) {
            $restaurantArray["restaurant"] = $restaurant;
            $this->restaurantsWithPopulatedData[] = $restaurantArray;
        }
    }
}