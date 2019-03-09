<?php

namespace App\Service\Restaurant\RestaurantGroupSupplier;

interface RestaurantGroupSupplierInterface
{
    /**
     * @param string $restaurantName
     * @return float|null if no rating return null else rating
    */
    public function getRating(string $restaurantName): ?float;

    /**
     * @param string $restaurantName
     * @return int|null
     */
    public function getReviewAmount(string $restaurantName): ?int;

    /**
     * @param string $restaurantName
     * @return array|null
     */
    public function getDetailedReview(string $restaurantName): ?array;

    /**
     * @param string $restaurantName
     * @return array|null
     */
    public function getRestaurantBranches(string $restaurantName): ?array;
}