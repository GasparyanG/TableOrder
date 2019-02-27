<?php

namespace App\Service\Review\ReviewMaker;

interface ReviewMakerInterface
{
    public function makeReview(int $restaurantId): bool;
}