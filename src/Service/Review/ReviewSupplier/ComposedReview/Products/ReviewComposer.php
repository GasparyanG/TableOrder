<?php

namespace App\Service\Review\ReviewSupplier\ComposedReview\Products;

use App\Service\ConfigurationFetcher\Templating\TemplatingConfigFetcherInterface;
use App\Service\Review\ReviewSupplier\ComposedReview\ComposedReviewInterface;

// entity
use App\Entity\User;
use App\Entity\Review;
use App\Service\Review\ReviewSupplier\ReviewSupplierInterface;

class ReviewComposer implements ComposedReviewInterface
{
    protected $composedReview;
    protected $reviewSupplier;
    protected $templatingConfigFetcher;

    public function __construct(ReviewSupplierInterface $reviewSupplier, TemplatingConfigFetcherInterface $templatingConfigFetcher)
    {
        $this->composedReview = [];
        $this->reviewSupplier = $reviewSupplier;
        $this->templatingConfigFetcher = $templatingConfigFetcher;
    }

    public function getComposedReview(User $user, bool $dashboard = true): array
    {
        $reviews = $this->reviewSupplier->getUserRatings($user, $dashboard);

        if (!$reviews) {
            return $reviews;
        }

        foreach($reviews as $review) {
            $singleReview = [];
            $singleReview[$this->templatingConfigFetcher->getReview()] = $review;
            $singleReview[$this->templatingConfigFetcher->getRestaurantRating()] = $this->addRestaurantRating($review);

            $this->composedReview[] = $singleReview;
        }

        return $this->composedReview;
    }

    protected function addRestaurantRating(Review $review): ?float
    {
        // this means that restaurant review will be search by restaurant id
        $restaurantName = null;
        $restaurantId = $review->getRestaurant()->getId();

        return $this->reviewSupplier->getReviewForRestaurant($restaurantName, $restaurantId);
    }
}