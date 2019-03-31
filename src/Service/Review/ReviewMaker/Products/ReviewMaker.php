<?php

namespace App\Service\Review\ReviewMaker\Products;

use App\Service\ConfigurationFetcher\Keys\KeysFetcherInterface;
use App\Service\ExternalSource\ExternalSourceSupplierInterface;
use App\Service\Review\ReviewMaker\ReviewMakerInterface;
use App\Service\User\UserSupporterInterface;

// symfony components
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Bridge\Doctrine\RegistryInterface;

// entities
use App\Entity\Review;
use App\Entity\Restaurant;

// DEV
use Psr\Log\LoggerInterface;

class ReviewMaker implements ReviewMakerInterface
{
    private $externalSourceSupplier;
    private $keysFetcher;
    private $userSupporter;
    private $validator;

    // db
    private $em;
    private $restaurantRepo;

    // DEV
    private $logger;

    public function __construct(ValidatorInterface $validator,
                                UserSupporterInterface $userSupporter,
                                RegistryInterface $doctrine,
                                ExternalSourceSupplierInterface $externalSourceSupplier,
                                KeysFetcherInterface $keysFetcher,
                                LoggerInterface $logger)
    {
        $this->externalSourceSupplier = $externalSourceSupplier;
        $this->keysFetcher = $keysFetcher;

        // repo config
        $this->em = $doctrine->getManager();
        $this->restaurantRepo = $this->em->getRepository(Restaurant::class);

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

        return true;
    }
}