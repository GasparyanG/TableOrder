<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Service\BaseLayout\BaseLayoutSupplierInterface;
use App\Service\Restaurant\RestaurantGroupSupplier\RestaurantGroupSupplierInterface;

// for dev perspective
use Psr\Log\LoggerInterface;


class RestaurantGroupController extends AbstractController
{
    public function getPage($restaurantName, BaseLayoutSupplierInterface $baseLayoutSupplier, RestaurantGroupSupplierInterface $restaurantGroupSupplier, LoggerInterface $logger)
    {
        $dataForClient = $this->getDataForClient($baseLayoutSupplier);
        $dataForClient["restaurantNamePlaceholder"] = $restaurantName;
        $dataForClient["amountOfReview"] = $restaurantGroupSupplier->getReviewAmount($restaurantName);
        $dataForClient["detailedReview"] = $restaurantGroupSupplier->getDetailedReview($restaurantName);
        $dataForClient["restaurantRating"] = $restaurantGroupSupplier->getRating($restaurantName);
        // restaurant's data
        $dataForClient["restaurantBranches"] = $restaurantGroupSupplier->getRestaurantBranches($restaurantName);

        return $this->render('restaurant_group/index.html.twig', $dataForClient);
    }

    private function getDataForClient($baseLayoutSupplier): array
    {
        $dataForClient = [];

        $dataForClient["cities"] = $baseLayoutSupplier->getLocation();
        $dataForClient["arrayOfPersonAmounts"] = $baseLayoutSupplier->getPersonAmount();

        return $dataForClient;
    }
}
