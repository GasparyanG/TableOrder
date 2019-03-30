<?php

namespace App\Service\Restaurant;

interface RestaurantSupplierInterface
{
    public function getRestaurantGroupReview(string $restaurantName): ?float;

    public function getRestaurantReview(int $restaurantId): ?float;

    public function visitedByUser(int $restaurantId): bool;

}