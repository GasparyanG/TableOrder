<?php

namespace App\Controller;

// use http\Env\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

// ajax search required services
use App\Service\Search\SearchFlow\Products\RestaurantSearchFlow;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use App\Service\Review\AbstractReview\AbstractReviewMakerInterface;
use Psr\Log\LoggerInterface;

class TestController extends AbstractController
{
    /**
     * @Route("/restaurants/{restaurantId}", name="test")
     */
    public function index(AbstractReviewMakerInterface $abstractReviewMaker, int $restaurantId, LoggerInterface $logger)
    {
        $success = false;

        if ($abstractReviewMaker->checkReviewState($restaurantId)) {
            $logger->info("start");
            $logger->info("review still not done");
            $logger->info("end");
        }

        else {
            $logger->info("start");
            $logger->info("interuption");
            $logger->info("end");
        }

        if ($abstractReviewMaker->checkServiceUsage($restaurantId)) {
            $logger->info("start");
            $logger->info("user already made reservation in this restaurant");
            $logger->info("end");
        }

        else {
            $logger->info("start");
            $logger->info("user didn't do any reservaion in this restaurant");
            $logger->info("end");
        }

        if ($abstractReviewMaker->makeReview($restaurantId)) {
            $success = true;   
        }

        else {
            $logger->info("start");
            $logger->info("Fuck; sth went wrong");
            $logger->info("end");
        }

        return $this->render('test/index.html.twig', [
            'controller_name' => 'TestController',
            'success' => $success
        ]);
    }

    // search from ajax perspective
    public function ajaxSearch(RestaurantSearchFlow $flow, LoggerInterface $logger)
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
        // $response->setContent(json_encode($dataToBeReturned));
        $response->headers->set('Content-Type', 'application/json');
        $response->setContent(json_encode($dataToBeReturned));

        return $response;
    }
}
