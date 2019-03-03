<?php

/**
 * - [] find out how to display 404 page
 * ::reserve
 * - [x] add timeAmount to session and then pass session array to checker
 * - [x] add person amount and location to twig
 * - [] user need to be authenticated to make reservation otherwise he/she need to be redirected to registration page
 * primary
 * - [x] see notebook to decide which data is need to send to client side
 */



namespace App\Controller;

use App\Service\Reservation\ReservationSupplier\Products\ReservationSupplier;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Psr\Log\LoggerInterface;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use App\Entity\RestaurantTable;
use App\Entity\Reservation;
use App\Entity\Restaurant;
use App\Entity\User;
use App\Service\ClientSideGuru\DefaultErrors\DefaultErrorMessageFetcherInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpFoundation\Response;
use App\Form\Search\Interfaces\SearchFormInterface;
use App\Service\Restaurant\RestaurantSupplierInterface;
use App\Service\Reservation\ReservationSupplier\ReservationSupplierInterface;

// new imp: bridge pattern approach
use App\Service\Reservation\Bridge\ReservationBridgeInterface;
use App\Service\Reservation\PostBridge\PostReservationBridgeInterface;

class ReservationController extends AbstractController
{
    public function __construct(DefaultErrorMessageFetcherInterface $defaultErrorMessageFetcher)
    {
        $this->defaultErrorMessageFetcher = $defaultErrorMessageFetcher;
    }

    public function getPage(Request $request, LoggerInterface $logger, ReservationBridgeInterface $reservationBridge, $restaurantName, $restaurantId, SearchFormInterface $formHelper, RestaurantSupplierInterface $restaurantSupplier, ReservationSupplierInterface $reservationSupplier)
    {
        // this section need to be changed to obey DRY principle
        $arrayOfData = $this->getCommonDataForClient($formHelper);
        $reservation = $reservationBridge->prepareReservationWithoutAmountOfTime();
        $arrayOfData["reservation"] = $reservation;

        // next, previous reservations
        $arrayOfData["prevReservation"] = $reservationSupplier->getPreviousReservation($reservation->getReservationTime()->format("H:i:s"), $reservation->getReservationDate()->format("Y-m-d"), $reservation->getTable());
        $arrayOfData["nextReservation"] = $reservationSupplier->getNextReservation($reservation->getReservationTime()->format("H:i:s"), $reservation->getReservationDate()->format("Y-m-d"), $reservation->getTable());

        $arrayOfData["review"] = $restaurantSupplier->getRestaurantGroupReview($reservation->getRestauran()->getName());

        $queryParams = $request->query->all();

        if (!$reservationBridge->restaurantExists($restaurantName, $restaurantId)) {
            // throw $this->createNotFoundException('The product does not exist');
            $arrayOfData["error"] = true;
            $this->render("reservation\index.html.twig", $arrayOfData);
        }

        $tableId = $reservationBridge->getRestaurantTableId($queryParams);
        if (!$tableId) {
            $arrayOfData["error"] = true;
            $this->render("reservation\index.html.twig", $arrayOfData);
        }

        // table exists
        else {
            if ($reservationBridge->tableExists($tableId, $restaurantId)) {
                $accessGranted = true;
            }

            else {
                $arrayOfData["error"] = true;
                $this->render("reservation\index.html.twig", $arrayOfData);
            }
        }

        // setting session: at this point it just remains (for session setting) to pass queryParams to setter
        $reservationBridge->replace($queryParams);

        // render this if above validation is passed
        return $this->render("reservation/index.html.twig", $arrayOfData);
    }

    public function reserve(PostReservationBridgeInterface $postReservationBridge, SearchFormInterface $formHelper, RestaurantSupplierInterface $restaurantSupplier, ReservationSupplierInterface $reservationSupplier)
    {
        // this section is being repeated
        $arrayOfData = $this->getCommonDataForClient($formHelper);

        $reservation = $postReservationBridge->prepareReservation();
        $arrayOfData["reservation"] = $reservation;

        // next and prev reservations
        $arrayOfData["prevReservation"] = $reservationSupplier->getPreviousReservation($reservation->getReservationTime()->format("H:i:s"), $reservation->getReservationDate()->format("Y-m-d"), $reservation->getTable());
        $arrayOfData["nextReservation"] = $reservationSupplier->getNextReservation($reservation->getReservationTime()->format("H:i:s"), $reservation->getReservationDate()->format("Y-m-d"), $reservation->getTable());

        // review
        $arrayOfData["review"] = $restaurantSupplier->getRestaurantGroupReview($reservation->getRestauran()->getName());

        $errors = $postReservationBridge->checkReservation($reservation);
        $arrayOfData["errors"] = $errors;

        // show errors
        if (count($errors) > 0) {
            return $this->render("reservation\index.html.twig", $arrayOfData);
        }

        // continue validating
        if (!$postReservationBridge->checkAmountOfTime($reservation)) {
            $validAmountOfTime = $postReservationBridge->getValidAmountOfTime($reservation);
            $arrayOfData['rightDuration'] = $validAmountOfTime;
            return $this->render("reservation\index.html.twig", $arrayOfData);
        }

        // make database record after validation
        $postReservationBridge->saveReservation($reservation);
        $arrayOfData["success"] = true;
        return $this->render("reservation\index.html.twig", $arrayOfData);
    }

    private function getCommonDataForClient($formHelper): array
    {
        $arrayOfData = [];
        $arrayOfData["cities"] = $formHelper->getLocationsForChoiceType();
        $arrayOfData["arrayOfPersonAmounts"] = $formHelper->getPersonAmountArray();
        $arrayOfData["errors"] = [];
        $arrayOfData["error"] = false;
        // right amount of time to reserve given table
        $arrayOfData["rightDuration"] = false;
        $arrayOfData["success"] = false;

        return $arrayOfData;
    }
}
