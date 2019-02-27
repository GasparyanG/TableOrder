<?php

namespace App\Service\Bookmark\AbstractBookmark;

interface AbstractBookmarkHandlerInterface
{
    /**
     * @param int $restaurantId this will be taken from url placeholder
     * @return bool
     */
    public function checkBookmarkState(int $restaurantId): bool;

    public function addBookmark(int $restaurantId): void;

    public function removeBookmark(int $restaurantId): void;
}