<?php

namespace App\Service\Bookmark\Products;

use App\Service\Bookmark\BookmarkSupplierInterface;
use App\Service\Restaurant\UserRestaurantInteraction\Bookmarking\BookmarkDescriberInterface;

class BookmarkSupplier implements BookmarkSupplierInterface
{
    private $bookmarkDescriber;

    public function __construct(BookmarkDescriberInterface $bookmarkDescriber)
    {
        $this->bookmarkDescriber = $bookmarkDescriber;
    }

    public function getUserComposedBookmarks(bool $dashboard = true): array
    {
        return $this->bookmarkDescriber->getUserComposedBookmarks($dashboard);
    }

    public function getAmountOfUserBookmarks(): int
    {
        return $this->bookmarkDescriber->getAmountOfUserBookmarks();
    }
}