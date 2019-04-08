<?php

namespace App\Controller;

use App\Service\User\UserSupporterInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Service\Bookmark\AbstractBookmark\AbstractBookmarkHandlerInterface;
use Symfony\Component\HttpFoundation\Response;

// DEV
use Psr\Log\LoggerInterface;

class BookmarkController extends AbstractController
{
    public function ajaxBookmark($restaurantId,
                                 AbstractBookmarkHandlerInterface $absBookmarkHandler,
                                 LoggerInterface $logger,
                                 UserSupporterInterface $userSupporter)
    {
        $bookmarkState["state"] = true;

        $user = $userSupporter->getUser();

        if ($user) {
            // change to integer form string
            $restaurantId = (int) $restaurantId;

            if ($absBookmarkHandler->checkBookmarkState($restaurantId)) {
                $bookmarkState["state"] = false;
                $absBookmarkHandler->removeBookmark($restaurantId);
            }

            else {
                $absBookmarkHandler->addBookmark($restaurantId);
            }
        }

        else {
            $bookmarkState["state"] = "redirect";
        }


        $jsonBookmarkState = json_encode($bookmarkState);

        $response = new Response();
        $response->headers->set("Content-Type", "application/json");

        $response->setContent($jsonBookmarkState);

        return $response;
    }
}
