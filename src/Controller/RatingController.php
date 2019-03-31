<?php

namespace App\Controller;

use App\Service\Review\AbstractReview\AbstractReviewMakerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class RatingController extends AbstractController
{
    public function addRating(int $restaurantId,
                              AbstractReviewMakerInterface $abstractReviewMaker,
                              LoggerInterface $logger)
    {
        $rated = false;

        if ($abstractReviewMaker->checkReviewState($restaurantId)) {
            if ($abstractReviewMaker->checkServiceUsage($restaurantId)) {

                if ($abstractReviewMaker->makeReview($restaurantId)) {
                    $rated = true;
                }
            }
        }

        $ratingState["state"] = $rated;

        $response = new Response();
        $response->headers->set("Content-Type", "application/json");
        $response->setContent(json_encode($ratingState));

        return $response;
    }
}
