<?php

namespace App\Service\Restaurant\Products;

use App\Service\Restaurant\RestaurantSupplierInterface;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Psr\Log\LoggerInterface;

// entities
use App\Entity\Review;
class RestaurantSupplier implements RestaurantSupplierInterface
{
    public function __construct(RegistryInterface $registry, loggerInterface $logger)
    {
        $this->logger =$logger;

        $this->em = $registry->getManager();
        $this->reviewRepo = $this->em->getRepository(Review::class);
    }

    public function getRestaurantGroupReview(string $restaurantName): ?float
    {
        $reviewOfRestaurant = $this->reviewRepo->getReview($restaurantName);

        if ($reviewOfRestaurant) {
            // this need to be dynamic
            return $reviewOfRestaurant[0]["avg_review"];
        }

        return null;
    }

    public function getRestaurantReview(int $restaurantId): ?float
    {
        // will be implemented soon
        return null;
    }
}