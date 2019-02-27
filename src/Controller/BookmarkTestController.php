<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\Bookmark\AbstractBookmark\AbstractBookmarkHandlerInterface;

class BookmarkTestController extends AbstractController
{
    /**
     * @Route("/restaurants/{restaurantId}/bookmark", name="bookmark_test")
     */
    public function index($restaurantId, AbstractBookmarkHandlerInterface $absBookmarkHandler)
    {
        $notAdded = false;
        if ($absBookmarkHandler->checkBookmarkState($restaurantId)) {
            $notAdded = true;
            $absBookmarkHandler->removeBookmark($restaurantId);
        }

        else {
            $absBookmarkHandler->addBookmark($restaurantId);
        }

        return $this->render('bookmark_test/index.html.twig', [
            "bookmarked" =>$notAdded
        ]);
    }
}
