<?php

namespace App\Service\Review\Checker\Products;

use App\Service\Review\Checker\ReviewCheckerInterface;
use Symfony\Bridge\Doctrine\RegistryInterface;
use App\Service\User\UserSupporterInterface;

// entities
use App\Entity\Review;
use App\Entity\Reservation;

class ReviewChecker implements ReviewCheckerInterface
{
    public function __construct(RegistryInterface $doctrine, UserSupporterInterface $userSupporter)
    {
        $this->userSupporter = $userSupporter;

        $this->doctrine = $doctrine;
        $em = $this->doctrine->getManager();
        $this->reviewRepo = $em->getRepository(Review::class);
        $this->reservationRepo = $em->getRepository(Reservation::class);
    }

    public function checkReviewState(int $restaurantId): bool
    {
        $user = $this->userSupporter->getUser();

        $review = $this->reviewRepo->findOneBy(["user" => $user, "restaurant" => $restaurantId]);
        if (!$review) {
            return true;
        }

        return false;
    }

    public function checkServiceUsage(int $restaurantId): bool
    {
        $user = $this->userSupporter->getUser();

        $reservation = $this->reservationRepo->findOneBy(["user" => $user, "restauran" => $restaurantId]);
        if ($reservation) {
            return true;
        }

        return false;
    }
}