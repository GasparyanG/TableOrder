<?php

namespace App\Service\Bookmark\BookmarkMaintaining;

interface BookmarkStateMaintainerInterface
{
    public function checkBookmarkState(int $restaurantId): bool;

    public function addBookmark(int $restaurantId): void;

    public function removeBookmark(int $restaurantId): void;
}