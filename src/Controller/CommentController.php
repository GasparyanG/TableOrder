<?php

namespace App\Controller;

use App\Service\Comment\AjaxHandler\AjaxHandlerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

// DEV
use Psr\Log\LoggerInterface;

class CommentController extends AbstractController
{
    public function addComment($restaurantId, AjaxHandlerInterface $ajaxHandler, LoggerInterface $logger)
    {
        $commentStatus = [];

        $isAdded = $ajaxHandler->addComment($restaurantId);

        $commentStatus["status"] = $isAdded;

        $response = new Response();
        $response->headers->set("Content-Type", "application/json");
        $response->setContent(json_encode($commentStatus));

        return $response;
    }
}
