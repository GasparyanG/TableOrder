<?php

namespace App\Controller;

use App\Service\BaseLayout\ClientDataComposerInterface;
use App\Service\Bookmark\BookmarkMaintaining\BookmarkStateMaintainerInterface;
use App\Service\Restaurant\RestaurantSupplierInterface;
use App\Service\User\Data\Composed\UserDataComposerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Form\Search\Interfaces\SearchFormInterface;
use App\Service\Review\ReviewSupplier\ReviewSupplierInterface;

use Symfony\Bridge\Doctrine\RegistryInterface;
use App\Service\Existence\Entity\ExistenceHandlerInterface;

// entities
use App\Entity\Restaurant;

use Psr\Log\LoggerInterface;

class RestaurantController extends AbstractController
{
    private $em;
    private $restaurantRepo;
    private $existenceHandler;

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
                            ClientDataComposerInterface $clientDataComposer,
                            LoggerInterface $logger)
    {
        // get base layout data
        $baseLayoutData = $clientDataComposer->composeData();

        // add bookmark state
        $bookmarkState = $bookmarkStateMaintainer->checkBookmarkState($restaurantId);
        $baseLayoutData["bookmarked"] = $bookmarkState;

        // add user data: uncomment if auth user requires
        // $userData = $userDataComposer->composeData();
        // $baseLayoutData["user"] = $userData;

        // add rated state
        $rated = $restaurantSupplier->ratedByUser($restaurantId);


        $rating = false;
        if ($rated) {
            $baseLayoutData["rating"] = $restaurantSupplier->getUserRating($restaurantId);
        }

        // add visiting state
        $visited = $restaurantSupplier->visitedByUser($restaurantId);
        $baseLayoutData["visited"] = $visited;

        // restaurant
        if (!$this->existenceHandler->restaurantExists($restaurantName, $restaurantId)) {
            throw new \RuntimeException("restaurant does not exists");
        }

        $baseLayoutData["restaurant"] = $this->restaurantRepo->findOneBy(["id" => $restaurantId, "name" => $restaurantName]);

        $baseLayoutData["review"] = $reviewSupplier->getReviewForRestaurant(null, $restaurantId);
        $baseLayoutData["amountOfReview"] = $reviewSupplier->getAmountOfReviewers(null, $restaurantId);
        $baseLayoutData["detailedReview"] = $reviewSupplier->getRestaurantDetailedReview(null, $restaurantId);

        // search area data
        return $this->render('restaurant/index.html.twig', $baseLayoutData);
    }
}
