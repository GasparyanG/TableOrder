<?php

namespace App\Service\Review\AbstractReview;

interface AbstractReviewMakerInterface
{
    /**
     * check to see whetehr user already make review or not
     * 
     * @param int $restaurantId this param is from url placeholders
     * @return bool
     */
    public function checkReviewState(int $restaurantId): bool;

    /**
     * check to see whetehr user make reservation for this restaurant or not
     * 
     * @param int $restaurantId this param is from url placeholders
     * @return bool
     */
    public function checkServiceUsage(int $restaurantId): bool;

    /**
     * make record to db review table!
     * 
     * @param int $restaurantId this param is from url placeholders
     * @return void
     */
    public function makeReview(int $restaurantId): bool;
}