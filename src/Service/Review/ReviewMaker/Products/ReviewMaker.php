<?php

namespace App\Service\Review\ReviewMaker\Products;

use App\Service\Review\ReviewMaker\ReviewMakerInterface;

// symfony components
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Service\ClientSideGuru\QueryString\Search\QueryStringFetcherInterface;
use App\Service\User\UserSupporterInterface;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Psr\Log\LoggerInterface;

// entities
use App\Entity\Review;
use App\Entity\Restaurant;

class ReviewMaker implements ReviewMakerInterface
{
    public function __construct(ValidatorInterface $validator, QueryStringFetcherInterface $fetcher, UserSupporterInterface $userSupporter, RegistryInterface $doctrine, LoggerInterface $logger)
    {
        // repo config
        $this->doctrine = $doctrine;
        $this->em = $this->doctrine->getManager();
        $this->restaurantRepo = $this->em->getRepository(Restaurant::class);

        $this->userSupporter = $userSupporter;
        $this->fetcher = $fetcher;
        $this->validator = $validator;
        $this->request = Request::createFromGlobals();

        $this->logger = $logger;
    }

    // if false then user need to know that something went wrong!
    public function makeReview(int $restaurantId): bool
    {
        $review = new Review();

        $postArray = $this->request->request->all();
        $this->logger->info("start");
        $this->logger->info(json_encode($postArray));
        $this->logger->info("end");
        $reviewValue = $this->fetcher->getReviewValue($postArray);

        $this->logger->info("start");
        $this->logger->info($reviewValue);
        $this->logger->info("end");

        if (!$reviewValue) {
            return false;
        }

        // actual value
        $review->setReview($reviewValue);
        // relations
        $review->setUser($this->userSupporter->getUser());
        $review->setRestaurant($this->restaurantRepo->find($restaurantId));
        
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