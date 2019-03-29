<?php

namespace App\Service\Review\ReviewSupplier;

use App\Entity\User;

interface ReviewSupplierInterface
{
    /**
     * @param string|null $restaurantName if this is set to null then search will be implemented based on restaurant id
     * @param int|null $restaurantId if this is set to null then search will be implemented based on restaurant name
     *
     * @return null|array
    */
    public function getReviewForRestaurant(?string $restaurantName, ?int $restaurantId = null): ?float;

    /**
     * @param string|null $restaurantName if this is et to null then search will be implemented based on restaurant id
     * @param int|null $restaurantId if this is set to null then search will be implemented based on restaurant name
     *
     * @return null|array
     */
    public function getAmountOfReviewers(?string $restaurantName, ?int $restaurantId = null): ?int;

    /**
     * @param string|null $restaurantName if this is et to null then search will be implemented based on restaurant id
     * @param int|null $restaurantId if this is set to null then search will be implemented based on restaurant name
     *
     * @return null|array
     */
    public function getRestaurantDetailedReview(?string $restaurantName, ?int $restaurantId = null): ?array;

    public function getUserRatings(User $user, bool $dashboard = true): array;

    public function getUserRatingAmount(User $user): int;
}