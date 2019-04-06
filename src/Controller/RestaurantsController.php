<?php

namespace App\Controller;

use App\Service\BaseLayout\ClientDataComposerInterface;
use App\Service\Restaurants\RestaurantSuperHandlerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class RestaurantsController extends AbstractController
{
    public function getPage(ClientDataComposerInterface $clientDataComposer, RestaurantSuperHandlerInterface $restaurantSuperHandler)
    {
        $dataForClient = $clientDataComposer->composeData();
        // get array of restaurants and add to dataForClient!

        $dataForClient["restaurants"] = $restaurantSuperHandler->getRestaurants();


        return $this->render('restaurants/index.html.twig', $dataForClient);
    }
}
