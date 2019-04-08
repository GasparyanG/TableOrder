<?php

namespace App\Controller;

use App\Service\BaseLayout\ClientDataComposerInterface;
use App\Service\Bookmark\BookmarkSupplierInterface;
use App\Service\Reservation\ReservationSupplier\ReservationSupplierInterface;
use App\Service\Restaurant\RestaurantData\RestaurantDataPopulaterInterface;
use App\Service\Review\ReviewSupplier\ComposedReview\ComposedReviewInterface;
use App\Service\Review\ReviewSupplier\ReviewSupplierInterface;
use App\Service\User\UserSupporterInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

// DEV
use Psr\Log\LoggerInterface;

class DashboardController extends AbstractController
{
    public function getPage(ClientDataComposerInterface $clientDataComposer,
                            ReservationSupplierInterface $reservationSupplier,
                            UserSupporterInterface $userSupporter,
                            ReviewSupplierInterface $reviewSupplier,
                            ComposedReviewInterface $reviewComposer,
                            BookmarkSupplierInterface $bookmarkSupplier,
                            LoggerInterface $logger)
    {
        // authentication
        // get dashboard required data and add to $client data!
        $user = $userSupporter->getUser();
        if (!$user) {
            return $this->redirectToRoute("sign_up");
        }

        $clientData = $clientDataComposer->composeData();

        // RESERVATIONS
        // adding reservations
        $reservations = $reservationSupplier->getUpcomingReservations($user);
        $clientData["reservations"] = $reservations;

        // amount of reservations done
        $amountOfReservations = $reservationSupplier->getAmountOfReservations($user);
        $clientData["amountOfReservations"] = $amountOfReservations;

        // RATINGS
        $reviews = $reviewSupplier->getUserRatings($user);

        if (count($reviews) === 0) {
            $clientData["reviews"] = null;
        }

        else {
            $clientData["reviews"] = $reviewComposer->getComposedReview($user);
        }

        // BOOKMARKS
        $clientData["bookmarks"] = $bookmarkSupplier->getUserComposedBookmarks();

        $clientData["amountOfBookmarks"] = $bookmarkSupplier->getAmountOfUserBookmarks();;

        $clientData["amountOfRatings"] = $reviewSupplier->getUserRatingAmount($user);

        return $this->render('dashboard/index.html.twig', $clientData);
    }
}
