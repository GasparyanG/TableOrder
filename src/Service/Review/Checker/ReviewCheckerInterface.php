<?php

namespace App\Service\Review\Checker;

interface ReviewCheckerInterface
{
    public function checkReviewState(int $restaurantId): bool;

    public function checkServiceUsage(int $restaurantId): bool;
}