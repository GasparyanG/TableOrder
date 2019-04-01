<?php

namespace App\Service\Restaurant\UserRestaurantInteraction\Bookmarking\Products;

use App\Service\ConfigurationFetcher\Database\DatabaseFetcherInterface;
use App\Service\ConfigurationFetcher\Keys\KeysFetcherInterface;
use App\Service\Restaurant\RestaurantData\SingleRestaurant\SingleRestaurantDataPreparing;
use App\Service\Restaurant\UserRestaurantInteraction\Bookmarking\BookmarkDescriberInterface;
use App\Service\User\UserSupporterInterface;

use App\Entity\Bookmark;
use Symfony\Bridge\Doctrine\RegistryInterface;

class BookmarkDescriber implements BookmarkDescriberInterface
{
    private $userSupporter;
    private $em;
    private $bookmarkRepo;
    private $databaseFetcher;
    private $keysFetcher;
    private $singleRestaurantDataPreparing;

    public function __construct(UserSupporterInterface $userSupporter,
                                RegistryInterface $registry,
                                DatabaseFetcherInterface $databaseFetcher,
                                KeysFetcherInterface $keysFetcher,
                                SingleRestaurantDataPreparing $singleRestaurantDataPreparing)
    {
        $this->userSupporter = $userSupporter;
        $this->databaseFetcher = $databaseFetcher;
        $this->keysFetcher = $keysFetcher;
        $this->singleRestaurantDataPreparing = $singleRestaurantDataPreparing;

        // bd
        $this->em = $registry->getEntityManager();
        $this->bookmarkRepo = $this->em->getRepository(Bookmark::class);
    }

    public function getUserComposedBookmarks(bool $dashboard = true): array
    {
        $arrayToReturn = [];

        $user = $this->userSupporter->getUser();

        // getting bookmarks
        $limit = $this->databaseFetcher->getDashboardDisplayingLimit();

        if (!$dashboard) {
            $limit = $this->databaseFetcher->getDashboardDisplayingMax();
        }

        $userBookmarks = $this->bookmarkRepo->getUserBookmarks($user, $limit);

        // restaurant population
        foreach($userBookmarks as $userBookmark) {
            $nestedArrayForBookmark = [];
            $nestedArrayForBookmark[$this->keysFetcher->getBookmark()] = $userBookmark;

            // populating restaurant
            $enhancedRestaurant = $this->singleRestaurantDataPreparing->populateRestaurant($userBookmark->getRestaurant());
            $nestedArrayForBookmark[$this->keysFetcher->getRestaurant()] = $enhancedRestaurant;

            $arrayToReturn[] = $nestedArrayForBookmark;
        }

        return $arrayToReturn;
    }

    public function getAmountOfUserBookmarks(): int
    {
        $user = $this->userSupporter->getUser();

        $amount = $this->bookmarkRepo->getAmountOfUserBookmarks($user);

        return $amount;
    }
}