<?php

namespace App\Service\Restaurant\UserRestaurantInteraction\Rating;

use App\Entity\Review;

interface RatingDescriberInterface
{
    public function ratedByUser(int $restaurantId): bool;

    public function getUserRating(int $restaurantId): Review;
}