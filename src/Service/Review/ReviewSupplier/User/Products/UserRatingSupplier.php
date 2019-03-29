<?php

namespace App\Service\Review\ReviewSupplier\User\Products;

use App\Entity\Review;
use App\Service\ConfigurationFetcher\Database\DatabaseFetcherInterface;
use App\Service\Review\ReviewSupplier\User\UserRatingsSupplierInterface;

// entity
use App\Entity\User;

// registry
use Symfony\Bridge\Doctrine\RegistryInterface;


class UserRatingSupplier implements UserRatingsSupplierInterface
{
    private $em;
    private $reviewRepo;
    private $databaseFetcher;

    public function __construct(RegistryInterface $registry, DatabaseFetcherInterface $databaseFetcher)
    {
        $this->databaseFetcher = $databaseFetcher;

        // db
        $this->em = $registry->getEntityManager();
        $this->reviewRepo = $this->em->getRepository(Review::class);
    }

    public function getUserRatings(User $user, bool $dashboard = true): array
    {
        $amountOfRatings = null;

        if ($dashboard) {
            $amountOfRatings = $this->databaseFetcher->getDashboardDisplayingLimit();
        }

        else {
            $amountOfRatings = $this->databaseFetcher->getDashboardDisplayingMax();
        }

        return $this->reviewRepo->findUserRatings($user, $amountOfRatings);
    }

    public function getUserRatingAmount(User $user): int
    {
        return $this->reviewRepo->getUserAmountOfRatings($user);
    }
}