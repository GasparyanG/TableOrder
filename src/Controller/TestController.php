<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

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
}
