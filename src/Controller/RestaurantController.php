<?php

namespace App\Controller;

use App\Service\Bookmark\BookmarkMaintaining\BookmarkStateMaintainerInterface;
use App\Service\Restaurant\RestaurantSupplierInterface;
use App\Service\User\Data\Composed\UserDataComposerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\Search\Interfaces\SearchFormInterface;
use App\Service\Review\ReviewSupplier\ReviewSupplierInterface;

use Symfony\Bridge\Doctrine\RegistryInterface;
use App\Service\Existence\Entity\ExistenceHandlerInterface;
// entities
use App\Entity\Restaurant;

use Psr\Log\LoggerInterface;

class RestaurantController extends AbstractController
{
    public function __construct(RegistryInterface $registry, ExistenceHandlerInterface $existenceHandler)
    {
        $this->em = $registry->getManager();
        $this->restaurantRepo = $this->em->getRepository(Restaurant::class);
        $this->existenceHandler = $existenceHandler;
    }

    public function getPage($restaurantName,
                            $restaurantId,
                            SearchFormInterface $formHelper,
                            ReviewSupplierInterface $reviewSupplier,
                            BookmarkStateMaintainerInterface $bookmarkStateMaintainer,
                            RestaurantSupplierInterface $restaurantSupplier,
                            UserDataComposerInterface $userDataComposer,
                            LoggerInterface $logger)
    {
        $bookmarkState = $bookmarkStateMaintainer->checkBookmarkState($restaurantId);

        // user data
        $userData = $userDataComposer->composeData();

        // rated
        $rated = $restaurantSupplier->ratedByUser($restaurantId);

        $rating = false;
        if ($rated) {
            $rating = $restaurantSupplier->getUserRating($restaurantId);
        }

        // visited
        $visited = $restaurantSupplier->visitedByUser($restaurantId);

        // restaurant
        if (!$this->existenceHandler->restaurantExists($restaurantName, $restaurantId)) {
            
        }

        $restaurant = $this->restaurantRepo->findOneBy(["id" => $restaurantId, "name" => $restaurantName]);

        $review = $reviewSupplier->getReviewForRestaurant(null, $restaurantId);
        $amountOfReview = $reviewSupplier->getAmountOfReviewers(null, $restaurantId);
        $detailedReview = $reviewSupplier->getRestaurantDetailedReview(null, $restaurantId);

        // search area data
        return $this->render('restaurant/index.html.twig', [
            "restaurant" => $restaurant,
            "review" => $review,
            "detailedReview" => $detailedReview,
            "amountOfReview" => $amountOfReview,
            "cities" => $formHelper->getLocationsForChoiceType(),
            "arrayOfPersonAmounts" => $formHelper->getPersonAmountArray(),
            "bookmarked" => $bookmarkState,
            "visited" => $visited,
            "rating" => $rating,
            "user" => $userData
        ]);
    }
}
