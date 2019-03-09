<?php

namespace App\Service\Restaurant\RestaurantGroupSupplier\Products;

use App\Service\Restaurant\RestaurantGroupSupplier\RestaurantGroupSupplierInterface;
use App\Service\Review\ReviewSupplier\ReviewSupplierInterface;
use App\Service\Restaurant\RestaurantSupplierInterface;
use Symfony\Bridge\Doctrine\RegistryInterface;
use App\Service\Restaurant\RestaurantData\RestaurantDataPopulaterInterface;

// entities
use App\Entity\Restaurant;

class RestaurantGroupSupplier implements RestaurantGroupSupplierInterface
{
    private $reviewSupplier;
    private $restaurantSupplier;
    private $em;
    private $restaurantRepo;
    private $restaurantDataPopulater;

    /**
     * RestaurantGroupSupplier constructor.
     * @param ReviewSupplierInterface $reviewSupplier
     * @param RestaurantSupplierInterface $restaurantSupplier
     */
    public function __construct(ReviewSupplierInterface $reviewSupplier, RestaurantSupplierInterface $restaurantSupplier, RegistryInterface $registry, RestaurantDataPopulaterInterface $restaurantDataPopulater)
    {
        // database
        $this->em = $registry->getManager();
        $this->restaurantRepo = $this->em->getRepository(Restaurant::class);

        $this->reviewSupplier = $reviewSupplier;
        $this->restaurantSupplier = $restaurantSupplier;
        $this->restaurantDataPopulater = $restaurantDataPopulater;
    }

    /**
     * @inheritdoc
     */
    public function getRating(string $restaurantName): ?float
    {
        return $this->restaurantSupplier->getRestaurantGroupReview($restaurantName);
    }

    /**
     * @inheritdoc
     */
    public function getReviewAmount(string $restaurantName): ?int
    {
        return $this->reviewSupplier->getAmountOfReviewers($restaurantName);
    }

    /**
     * @inheritdoc
     */
    public function getDetailedReview(string $restaurantName): ?array
    {
        return $this->reviewSupplier->getRestaurantDetailedReview($restaurantName);
    }

    /**
     * @inheritdoc
     */
    public function getRestaurantBranches(string $restaurantName): ?array
    {
        $restaurants = $this->restaurantRepo->findBy(["name" => $restaurantName]);

        if (!$restaurants) {
            return null;
        }

        return $this->restaurantDataPopulater->populateRestaurantWithData($restaurants);
    }
}