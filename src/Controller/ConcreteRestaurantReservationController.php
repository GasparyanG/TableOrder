<?php

namespace App\Controller;

use App\Service\BaseLayout\ClientDataComposerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

use App\Service\Search\SearchFlow\Products\RestaurantSearchFlow;
use App\Form\Search\Interfaces\SearchFormInterface;
use Symfony\Component\HttpFoundation\Request;

use Psr\Log\LoggerInterface;

class ConcreteRestaurantReservationController extends AbstractController
{
    public function search(RestaurantSearchFlow $flow,
                           SearchFormInterface $formHelper,
                           LoggerInterface $logger,
                           ClientDataComposerInterface $clientDataComposer)
    {
        $arrayOfData = $clientDataComposer->composeData();
        $arrayOfData["notReservedTables"] = $flow->getNotReservedTables();

        $request = Request::createFromGlobals();

        $arrayOfData["queryParams"] = $request->query->all();

        return $this->render('concrete_restaurant_reservation/index.html.twig', $arrayOfData);
    }
}
