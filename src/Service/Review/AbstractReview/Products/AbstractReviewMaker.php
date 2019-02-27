<?php

namespace App\Service\Review\AbstractReview\Products;

use App\Service\Review\AbstractReview\AbstractReviewMakerInterface;
use App\Service\Review\Checker\ReviewCheckerInterface;
use App\Service\Review\ReviewMaker\ReviewMakerInterface;

/**
 * for more info about methods and class
 * @see App\Service\Review\AbstractReview\AbstractReviewMakerInterface
 */
class AbstractReviewMaker implements AbstractReviewMakerInterface
{
    public function __construct(ReviewCheckerInterface $reviewChecker, ReviewMakerInterface $reviewMaker)
    {
        $this->reviewChecker = $reviewChecker;
        $this->reviewMaker = $reviewMaker;
    }

    public function checkReviewState(int $restaurantId): bool
    {
        return $this->reviewChecker->checkReviewState($restaurantId);
    }

    public function checkServiceUsage(int $restaurantId): bool
    {
        return $this->reviewChecker->checkServiceUsage($restaurantId);
    }

    public function makeReview(int $restaurantId): bool
    {
        return $this->reviewMaker->makeReview($restaurantId);
    }
}