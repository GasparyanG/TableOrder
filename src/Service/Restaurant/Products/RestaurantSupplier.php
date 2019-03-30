<?php

namespace App\Service\Restaurant\Products;

use App\Service\Restaurant\UserRestaurantInteraction\Visiting\VisitDescriberInterface;
use App\Service\Restaurant\RestaurantSupplierInterface;
use Symfony\Bridge\Doctrine\RegistryInterface;

// entities
use App\Entity\Review;

// DEV
use Psr\Log\LoggerInterface;


class RestaurantSupplier implements RestaurantSupplierInterface
{
    private $em;
    private $reviewRepo;
    private $visitDescriber;

    // DEV
    private $logger;

    public function __construct(RegistryInterface $registry,
                                loggerInterface $logger,
                                VisitDescriberInterface $visitDescriber)
    {
        $this->em = $registry->getManager();
        $this->reviewRepo = $this->em->getRepository(Review::class);
        $this->visitDescriber = $visitDescriber;

        // DEV
        $this->logger =$logger;
    }

    public function getRestaurantGroupReview(string $restaurantName): ?float
    {
        $reviewOfRestaurant = $this->reviewRepo->gerRestaurantGroupReview($restaurantName);

        if ($reviewOfRestaurant) {
            // this need to be dynamic
            return $reviewOfRestaurant[0]["avg_review"];
        }

        return null;
    }

    public function getRestaurantReview(int $restaurantId): ?float
    {

        $reviewOfRestaurant = $this->reviewRepo->getReview($restaurantId);

        if ($reviewOfRestaurant) {
            return $reviewOfRestaurant[0]["avg_review"];
        }

        return null;
    }

    public function visitedByUser(int $restaurantId): bool
    {
        return $this->visitDescriber->visitedByUser($restaurantId);
    }
}