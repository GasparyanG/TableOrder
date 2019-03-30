<?php

namespace App\Service\Restaurant\UserRestaurantInteraction\Visiting;

interface VisitDescriberInterface
{
    public function visitedByUser(int $restaurantId): bool;
}