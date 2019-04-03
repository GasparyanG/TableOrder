<?php

namespace App\Controller;

use App\Entity\Restaurant;
use App\Service\BaseLayout\ClientDataComposerInterface;
use App\Service\ConfigurationFetcher\Keys\KeysFetcherInterface;
use App\Service\DatabaseHighLvlManipulation\Insertion\Reservation\ReservationInsertionInterface;
use App\Service\Reservation\ReservationSupplier\ReservationSupplierInterface;
use App\Service\Reservation\Validation\ReservationValidationInterface;
use App\Service\Restaurant\RestaurantData\SingleRestaurantDataPreparingInterface;
use App\Service\User\UserSupporterInterface;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

use App\Entity\RestaurantTable;

class ReservationController extends AbstractController
{
    private $clientDataComposer;
    private $userSupporter;
    private $reservationValidation;
    private $request;
    private $keysFetcher;
    private $reservationSupplier;
    private $singleRestaurantDataPreparing;
    private $reservationInserter;

    // db
    private $em;
    private $restaurantRepo;
    private $restaurantTableRepo;


    public function __construct(ClientDataComposerInterface $clientDataComposer,
                                UserSupporterInterface $userSupporter,
                                ReservationValidationInterface $reservationValidation,
                                KeysFetcherInterface $keysFetcher,
                                ReservationSupplierInterface $reservationSupplier,
                                RegistryInterface $registry,
                                ReservationInsertionInterface $reservationInserter,
                                SingleRestaurantDataPreparingInterface $singleRestaurantDataPreparing)
    {
        $this->clientDataComposer = $clientDataComposer;
        $this->userSupporter = $userSupporter;
        $this->reservationValidation = $reservationValidation;
        $this->request = Request::createFromGlobals();
        $this->keysFetcher = $keysFetcher;
        $this->reservationSupplier = $reservationSupplier;
        $this->singleRestaurantDataPreparing = $singleRestaurantDataPreparing;
        $this->reservationInserter = $reservationInserter;

        // db
        $this->em = $registry->getEntityManager();
        $this->restaurantRepo = $this->em->getRepository(Restaurant::class);
        $this->restaurantTableRepo = $this->em->getRepository(RestaurantTable::class);
    }

    public function getPage(string $restaurantName, int $restaurantId)
    {
        // only authenticated user can make reservation !
        if (!$this->userSupporter->getUser()) {
            return $this->redirectToRoute("sign_up");
        }

        // checking query string validity
        $valid = $this->reservationValidation->getRequestIsValid($restaurantName, $restaurantId);

        if ($valid) {
            $clientData = $this->getClientData($restaurantId);
        }

        else {
            $clientData = $this->clientDataComposer->composeData();
        }

        $clientData["valid"] = $valid;

        return $this->render("reservation/index.html.twig", $clientData);
    }


    public function reserve(string $restaurantName, int $restaurantId)
    {
        // only authenticated user can make reservation !
        if (!$this->userSupporter->getUser()) {
            return $this->redirectToRoute("sign_up");
        }

        // request flow will change this to false if required
        $valid = true;

        // check post request and return errors if any
        $errors = $this->reservationValidation->postRequestValidation($restaurantName, $restaurantId);

        // this will happen if 'get' request is wrong!
        if ($errors === null) {
            $valid = false;
        }

        // insert $reservation to database and redirect
        elseif (count($errors) == 0) {
            $reservation = $this->reservationInserter->getPopulatedObject($restaurantName, $restaurantId);
            $this->reservationInserter->insertIntoDatabase($reservation);

            return $this->redirectToRoute("dashboard");
        }

        if ($valid) {
            $clientData = $this->getClientData($restaurantId);
        }

        else {
            $clientData = $this->clientDataComposer->composeData();
        }

        $clientData["valid"] = $valid;

        // send errors to client
        $clientData["errors"] = $errors;

        return $this->render("reservation/index.html.twig", $clientData);
    }


    private function getClientData(int $restaurantId): array
    {
        $clientData = $this->clientDataComposer->composeData();

        // errors
        $clientData["errors"] = [];

        $queryParams = $this->request->query->all();

        // add previous and next reservations
        $reservationTime = $queryParams[$this->keysFetcher->getReservationTime()];
        $reservationDate = $queryParams[$this->keysFetcher->getReservationDate()];
        $tableId = $queryParams[$this->keysFetcher->getTableId()];

        $clientData["reservationDetails"] = $queryParams;

        $clientData["nextReservation"] = $this->reservationSupplier->getNextReservation($reservationTime, $reservationDate, $tableId);
        $clientData["previousReservation"] = $this->reservationSupplier->getPreviousReservation($reservationTime, $reservationDate, $tableId);

        $clientData["tableToReserve"] = $this->restaurantTableRepo->find($tableId);

        // add restaurant data
        $restaurant = $this->restaurantRepo->find($restaurantId);
        $clientData["restaurantData"] = $this->singleRestaurantDataPreparing->populateRestaurant($restaurant);

        return $clientData;
    }
}