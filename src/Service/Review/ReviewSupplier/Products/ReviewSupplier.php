<?php

namespace App\Service\Review\ReviewSupplier\Products;

use App\Service\Review\ReviewSupplier\ReviewSupplierInterface;
use Symfony\Bridge\Doctrine\RegistryInterface;

// entities
use App\Entity\Review;
use Psr\Log\LoggerInterface;

class ReviewSupplier implements ReviewSupplierInterface
{
    public function __construct(RegistryInterface $registry, LoggerInterface $logger)
    {
        $this->ratings = [5, 4, 3, 2, 1];

        $this->logger = $logger;
        $this->matchAll = "%";

        $this->em = $registry->getManager();
        $this->reviewRepo = $this->em->getRepository(Review::class);
    }

    public function getReviewForRestaurant(?string $restaurantName, ?int $restaurantId = null): ?float
    {
        if ($restaurantName) {
            $review = $this->reviewRepo->getRestaurantGroupReview($restaurantName);
            if (count($review) === 0) {
                return null;
            }

            return $review[0]["avg_review"];
        } elseif ($restaurantId) {
            $review = $this->reviewRepo->getReview($restaurantId);
            if (count($review) === 0) {
                return null;
            }

            return $review[0]["avg_review"];
        }
    }

    public function getAmountOfReviewers(?string $restaurantName, ?int $restaurantId = null): ?int
    {
        if ($restaurantName) {
            $review = $this->reviewRepo->findRestaurantGroupAmountOfReview($restaurantName);
            if (count($review) === 0) {
                return null;
            }

            return $review[0]["amountOfReview"];
        } elseif ($restaurantId) {
            $review = $this->reviewRepo->findAmountOfReview($restaurantId);
            if (count($review) === 0) {
                return null;
            }

            return $review[0]["amountOfReview"];
        }
    }

    public function getRestaurantDetailedReview(?string $restaurantName, ?int $restaurantId = null): ?array
    {
        $arrayOfRatings = [];

        if ($restaurantName) {
            foreach ($this->ratings as $rating) {
                $review = $this->reviewRepo->findRestaurantGroupSpecificAmountOfReview($restaurantName, $rating);
                if (count($review) === 0) {
                    $arrayOfRatings[] = 0;
                }

                $arrayOfRatings[] = $review[0]["amountOfReview"];
            }

            return $arrayOfRatings;
        } elseif ($restaurantId) {
            foreach ($this->ratings as $rating) {
                $review = $this->reviewRepo->findSpecificAmountOfReview($restaurantId, $rating);
                if (count($review) === 0) {
                    $arrayOfRatings[] = 0;
                }
                $arrayOfRatings[] = $review[0]["amountOfReview"];

            }

            return $arrayOfRatings;
        }
    }
}