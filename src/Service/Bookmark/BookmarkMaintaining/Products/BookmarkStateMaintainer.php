<?php

namespace App\Service\Bookmark\BookmarkMaintaining\Products;

use App\Service\Bookmark\BookmarkMaintaining\BookmarkStateMaintainerInterface;
use Symfony\Bridge\Doctrine\RegistryInterface;
use App\Service\User\UserSupporterInterface;
// entities
use App\Entity\Bookmark;
use App\Entity\Restaurant;

class BookmarkStateMaintainer implements BookmarkStateMaintainerInterface
{
    public function __construct(RegistryInterface $doctrine, UserSupporterInterface $userSupporter)
    {
        // repo config
        $this->doctrine = $doctrine;
        $this->em = $this->doctrine->getManager();
        $this->bookmarkRepo = $this->em->getRepository(Bookmark::class);
        $this->restaurantRepo = $this->em->getRepository(Restaurant::class);
        // user supporter
        $this->userSupporter = $userSupporter;
    }

    public function checkBookmarkState(int $restaurantId): bool
    {
        // user
        $user = $this->userSupporter->getUser();

        $bookmark = $this->bookmarkRepo->findOneBy(["user" => $user, "restaurant" => $restaurantId]);

        if($bookmark) {
            return true;
        }

        return false;
    }

    public function addBookmark(int $restaurantId): void
    {
        $user = $this->userSupporter->getUser();

        $bookmark = new Bookmark();
        $bookmark->setRestaurant($this->getRestaurant($restaurantId));
        $bookmark->setUser($user);
        // date time setting
        $dbFormat = date("Y-m-d H:i:s", time());
        $dateTime = new \DateTime($dbFormat);
        $bookmark->setBookmarkDateTime($dateTime);

        $this->em->persist($bookmark);
        $this->em->flush();
    }

    public function removeBookmark(int $restaurantId): void
    {
        $user = $this->userSupporter->getUser();
        $bookmark = $this->bookmarkRepo->findOneBy(["user" => $user, "restaurant" =>$restaurantId]);

        $this->em->remove($bookmark);
        $this->em->flush();
    }

    private function getRestaurant(int $restaurantId): Restaurant
    {
        return $this->restaurantRepo->find($restaurantId);
    }
}