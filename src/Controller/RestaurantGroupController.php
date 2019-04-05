<?php

namespace App\Controller;

use App\Service\BaseLayout\ClientDataComposerInterface;
use App\Service\User\Data\Composed\UserDataComposerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Service\Restaurant\RestaurantGroupSupplier\RestaurantGroupSupplierInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

// ajax search specific
use App\Service\Search\SearchFlow\SearchFlowInterface;

// for dev perspective
use Psr\Log\LoggerInterface;


class RestaurantGroupController extends AbstractController
{
    public function getPage($restaurantName,
                            ClientDataComposerInterface $clientDataComposer,
                            RestaurantGroupSupplierInterface $restaurantGroupSupplier,
                            UserDataComposerInterface $userDataComposer,
                            LoggerInterface $logger)
    {
        $dataForClient = $clientDataComposer->composeData();

        $dataForClient["restaurantNamePlaceholder"] = $restaurantName;
        $dataForClient["amountOfReview"] = $restaurantGroupSupplier->getReviewAmount($restaurantName);
        $dataForClient["detailedReview"] = $restaurantGroupSupplier->getDetailedReview($restaurantName);
        $dataForClient["restaurantRating"] = $restaurantGroupSupplier->getRating($restaurantName);
        // restaurant's data
        $dataForClient["restaurantBranches"] = $restaurantGroupSupplier->getRestaurantBranches($restaurantName);

        // $dataForClient["user"] = $userDataComposer->composeData();

        return $this->render('restaurant_group/index.html.twig', $dataForClient);
    }

    public function ajaxSearch(SearchFlowInterface $flow, LoggerInterface $logger)
    {
        $notReservedTables = $flow->getNotReservedTables();

        $dataToBeReturned["tableState"] = null;
        if (is_array($notReservedTables)) {
            if (count($notReservedTables) > 0) {
                // this will mean to redirect to results directory from client
                $dataToBeReturned["tableState"] = true;
            }

            else {
                $dataToBeReturned["tableState"] = false;
            }
        }

        // preparing response: this can be done very easily with JsonResponse, but this is a better way
        // to understand mechanism of working
        $response = new Response();

        $response->headers->set('Content-Type', 'application/json');
        $response->setContent(json_encode($dataToBeReturned));
        // $response->setContent(json_encode($notReservedTables));

        return $response;
    }

    public function search(SearchFlowInterface $flow,
                           ClientDataComposerInterface $clientDataComposer,
                           UserDataComposerInterface $userDataComposer,
                           Request $request)
    {
        $dataForClient = $clientDataComposer->composeData();
        $notReservedTables = $flow->getNotReservedTables();

        $dataForClient["notReservedTables"] = $notReservedTables;
        $dataForClient["queryParams"] = $request->query->all();
        $dataForClient["user"] = $userDataComposer->composeData();

        return $this->render("concrete_restaurant_reservation/index.html.twig", $dataForClient);
    }
}
