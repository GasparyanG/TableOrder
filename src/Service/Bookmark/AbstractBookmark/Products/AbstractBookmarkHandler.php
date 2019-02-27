<?php

namespace App\Service\Bookmark\AbstractBookmark\Products;

use App\Service\Bookmark\AbstractBookmark\AbstractBookmarkHandlerInterface;
use App\Service\Bookmark\BookmarkMaintaining\BookmarkStateMaintainerInterface;

class AbstractBookmarkHandler implements AbstractBookmarkHandlerInterface
{
    public function __construct(BookmarkStateMaintainerInterface $bookmarkMaintainer)
    {
        $this->bookmarkMaintainer = $bookmarkMaintainer;
    }

    public function checkBookmarkState(int $restaurantId): bool
    {
        return $this->bookmarkMaintainer->checkBookmarkState($restaurantId);
    }

    public function addBookmark(int $restaurantId): void
    {
        $this->bookmarkMaintainer->addBookmark($restaurantId);
    }

    public function removeBookmark(int $restaurantId): void
    {
        $this->bookmarkMaintainer->removeBookmark($restaurantId);
    }
}