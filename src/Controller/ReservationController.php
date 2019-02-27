<?php

/**
 * []- find out how to display 404 page
 * ::reserve
 * []- add timeAmount to session and then pass session array to checker
 */

namespace App\Controller;

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

// new imp: bridge pattern approach
use App\Service\Reservation\Bridge\ReservationBridgeInterface;
use App\Service\Reservation\PostBridge\PostReservationBridgeInterface;

class ReservationController extends AbstractController
{
    public function __construct(DefaultErrorMessageFetcherInterface $defaultErrorMessageFetcher)
    {
        $this->defaultErrorMessageFetcher = $defaultErrorMessageFetcher;
    }

    public function getPage(Request $request, LoggerInterface $logger, ReservationBridgeInterface $reservationBridge, $restaurantName, $restaurantId)
    {
        $accessGranted = false;
        $errors = [];
        $queryParams = $request->query->all();

        if (!$reservationBridge->restaurantExists($restaurantName, $restaurantId)) {
            throw $this->createNotFoundException('The product does not exist');            
        }

        $tableId = $reservationBridge->getRestaurantTableId($queryParams);
        if (!$tableId) {
            $errors[] = $this->defaultErrorMessageFetcher->getTableIdIsNotDefined();
        }

        // table exists
        else {
            if ($reservationBridge->tableExists($tableId, $restaurantId)) {
                $accessGranted = true;
            }

            else {
                $errors[] = $this->defaultErrorMessageFetcher->getTableIdIsNotDefined();
            }
        }

        // setting session: at this point it just remains (for session setting) to pass queryParams to setter
        $reservationBridge->replace($queryParams);

        // render this if above validation is passed
        return $this->render("reservation/index.html.twig", [
            "errors" => $errors,
            "accessGranted" => $accessGranted
        ]);
    }

    public function reserve(PostReservationBridgeInterface $postReservationBridge)
    {
        $reservation = $postReservationBridge->prepareReservation();
        $errors = $postReservationBridge->checkReservation($reservation);

        // show errors
        if (count($errors) > 0) {
            return new Response(json_encode($errors));
        }

        // continue validating
        if (!$postReservationBridge->checkAmountOfTime($reservation)) {
            $validAmountOfTime = $postReservationBridge->getValidAmountOfTime($reservation);
            return new Response($validAmountOfTime);
        }

        // make database record after validation
        $postReservationBridge->saveReservation($reservation);
        
        return $this->redirectToRoute("success");
    }
}
