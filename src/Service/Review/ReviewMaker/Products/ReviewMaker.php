<?php

namespace App\Service\Review\ReviewMaker\Products;

use App\Service\ConfigurationFetcher\Keys\KeysFetcherInterface;
use App\Service\ExternalSource\ExternalSourceSupplierInterface;
use App\Service\Restaurant\RestaurantSupplierInterface;
use App\Service\Review\ReviewMaker\ReviewMakerInterface;
use App\Service\User\UserSupporterInterface;

// symfony components
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Bridge\Doctrine\RegistryInterface;

// entities
use App\Entity\Review;
use App\Entity\Restaurant;
use App\Entity\RestaurantDetails;

// DEV
use Psr\Log\LoggerInterface;

class ReviewMaker implements ReviewMakerInterface
{
    private $externalSourceSupplier;
    private $keysFetcher;
    private $userSupporter;
    private $validator;
    private $restaurantSupplier;

    // db
    private $em;
    private $restaurantRepo;
    private $restaurantDetRepo;

    // DEV
    private $logger;

    public function __construct(ValidatorInterface $validator,
                                UserSupporterInterface $userSupporter,
                                RegistryInterface $doctrine,
                                ExternalSourceSupplierInterface $externalSourceSupplier,
                                KeysFetcherInterface $keysFetcher,
                                RestaurantSupplierInterface $restaurantSupplier,
                                LoggerInterface $logger)
    {
        $this->externalSourceSupplier = $externalSourceSupplier;
        $this->keysFetcher = $keysFetcher;
        $this->restaurantSupplier = $restaurantSupplier;

        // repo config
        $this->em = $doctrine->getManager();
        $this->restaurantRepo = $this->em->getRepository(Restaurant::class);
        $this->restaurantDetRepo = $this->em->getRepository(RestaurantDetails::class);

        $this->userSupporter = $userSupporter;
        $this->validator = $validator;


        // DEV
        $this->logger = $logger;
    }

    // if false then user need to know that something went wrong!
    public function makeReview(int $restaurantId): bool
    {
        $review = new Review();

        $jsonFromClient = $this->externalSourceSupplier->getPhpInputFileContent();
        $jsonToAssocArray = json_decode($jsonFromClient, true);

        if (!$jsonToAssocArray) {
            return false;
        }

        $reviewValue = $jsonToAssocArray[$this->keysFetcher->getRating()];

        // actual value
        $review->setReview($reviewValue);

        // user
        $user = $this->userSupporter->getUser();
        $review->setUser($user);

        // restaurant
        $restaurant = $this->restaurantRepo->find($restaurantId);
        $review->setRestaurant($restaurant);

        //restaurant name
        $review->setRestaurantName($restaurant->getName());

        // setting time and date
        $currentTime = time();

        // time
        $time = new \DateTime(date("H:i:s", $currentTime));
        $review->setReviewTime($time);

        //date
        $date = new \DateTime(date("Y-m-d", $currentTime));
        $review->setDate($date);

        $errors = $this->validator->validate($review);

        if (count($errors) > 0) {
            return false;
        }

        // making record(i.e. saving)
        $this->em->persist($review);
        $this->em->flush();

        // set overall rating in restaurant details table;
        $this->updateRestaurantRating($restaurant);

        return true;
    }

    private function updateRestaurantRating(Restaurant $restaurant): void
    {
        $name = $restaurant->getName();
        $restaurantGroupRating = $this->restaurantSupplier->getRestaurantGroupReview($name);

        $restaurantDet = $this->restaurantDetRepo->findOneBy(["name" => $name]);
        $restaurantDet->setRating($restaurantGroupRating);

        $this->em->persist($restaurantDet);
        $this->em->flush();
    }
}