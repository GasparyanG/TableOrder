<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Service\Bookmark\AbstractBookmark\AbstractBookmarkHandlerInterface;
use Symfony\Component\HttpFoundation\Response;

// DEV
use Psr\Log\LoggerInterface;

class BookmarkController extends AbstractController
{
    public function ajaxBookmark($restaurantId, AbstractBookmarkHandlerInterface $absBookmarkHandler, LoggerInterface $logger)
    {

        $notAdded = false;
        // change to integer form string
        $restaurantId = (int) $restaurantId;

        if ($absBookmarkHandler->checkBookmarkState($restaurantId)) {
            $notAdded = true;
            $absBookmarkHandler->removeBookmark($restaurantId);
        }

        else {
            $absBookmarkHandler->addBookmark($restaurantId);
        }

        $currentState = !$notAdded;

        $jsonBookmarkState = json_encode($currentState);

        $response = new Response();
        $response->headers->set("Content-Type", "application/json");

        $response->setContent($jsonBookmarkState);

        return $response;
    }
}
