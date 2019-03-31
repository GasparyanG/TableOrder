<?php

namespace App\Service\Restaurant;

use App\Entity\Review;

interface RestaurantSupplierInterface
{
    public function getRestaurantGroupReview(string $restaurantName): ?float;

    public function getRestaurantReview(int $restaurantId): ?float;

    public function visitedByUser(int $restaurantId): bool;

    public function ratedByUser(int $restaurantId): bool;

    public function getUserRating(int $restaurantId): Review;
}