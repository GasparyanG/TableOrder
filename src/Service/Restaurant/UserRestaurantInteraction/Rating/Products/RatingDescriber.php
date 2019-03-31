<?php

namespace App\Service\Restaurant\UserRestaurantInteraction\Rating\Products;

use App\Service\Restaurant\UserRestaurantInteraction\Rating\RatingDescriberInterface;
use App\Service\User\UserSupporterInterface;
use Symfony\Bridge\Doctrine\RegistryInterface;

// entity
use App\Entity\Review;

class RatingDescriber implements RatingDescriberInterface
{
    private $em;
    private $reviewRepo;
    private $userSupporter;

    public function __construct(RegistryInterface $registry, UserSupporterInterface $userSupporter)
    {
        $this->userSupporter = $userSupporter;

        // db
        $this->em = $registry->getEntityManager();
        $this->reviewRepo = $this->em->getRepository(Review::class);
    }

    public function ratedByUser(int $restaurantId): bool
    {
        $user = $this->userSupporter->getUser();

        $review = $this->reviewRepo->findOneBy(["user" => $user, "restaurant" => $restaurantId]);

        if ($review) {
            return true;
        }

        return false;
    }

    public function getUserRating(int $restaurantId): Review
    {
        $user = $this->userSupporter->getUser();

        $review = $this->reviewRepo->findOneBy(["user" => $user, "restaurant" => $restaurantId]);

        return $review;

    }
}