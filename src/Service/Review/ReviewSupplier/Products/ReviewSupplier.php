<?php

namespace App\Service\Review\ReviewSupplier\Products;

use App\Service\Review\ReviewSupplier\ReviewSupplierInterface;
use App\Service\Review\ReviewSupplier\User\UserRatingsSupplierInterface;
use Symfony\Bridge\Doctrine\RegistryInterface;

// entities
use App\Entity\Review;
use Psr\Log\LoggerInterface;
use App\Entity\User;

class ReviewSupplier implements ReviewSupplierInterface
{
    private $ratings;
    private $matchAll;
    private $em;
    private $reviewRepo;
    private $userRatingsSupplier;

    // dev
    private $logger;

    public function __construct(RegistryInterface $registry, UserRatingsSupplierInterface $userRatingsSupplier, LoggerInterface $logger)
    {
        // static config: TODO: forward to yaml config files!
        $this->ratings = [5, 4, 3, 2, 1];
        $this->matchAll = "%";

        $this->userRatingsSupplier = $userRatingsSupplier;

        // db
        $this->em = $registry->getManager();
        $this->reviewRepo = $this->em->getRepository(Review::class);

        // dev
        $this->logger = $logger;
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

    public function getUserRatings(User $user, bool $dashboard = true): array
    {
        return $this->userRatingsSupplier->getUserRatings($user, $dashboard);
    }

    public function getUserRatingAmount(User $user): int
    {
        return $this->userRatingsSupplier->getUserRatingAmount($user);
    }
}