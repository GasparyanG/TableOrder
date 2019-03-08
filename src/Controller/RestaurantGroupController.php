<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\Search\Interfaces\SearchFormInterface;

class RestaurantGroupController extends AbstractController
{
    public function getPage($restaurantName, SearchFormInterface $formHelper)
    {
        $dataForClient = $this->getDataForClient($formHelper);
        $dataForClient["restaurantNamePlaceholder"] = $restaurantName;

        return $this->render('restaurant_group/index.html.twig', $dataForClient);

    }

    private function getDataForClient($formHelper): array
    {
        $dataForClient = [];

        $dataForClient["cities"] = $formHelper->getLocationsForChoiceType();
        $dataForClient["arrayOfPersonAmounts"] = $formHelper->getPersonAmountArray();

        return $dataForClient;
    }
}
